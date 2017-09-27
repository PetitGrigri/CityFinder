<?php
namespace CityFinderBundle\Command;


use CityFinderBundle\Entity\DonneesCommunes;
use CityFinderBundle\Node\Commune;
use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Doctrine\ORM\EntityManager;
use PDO;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ClearAndLoadCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('cityfinder:load')

            // the short description shown while running "php bin/console list"
            ->setDescription('Load Neo4j CityFinder Dtabase.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('Clear Neo4j Database and create nodes from Doctrine Database.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $emDoctrine  = $this->getContainer()->get('doctrine')->getManager();
        $connectionDoctrine = $this->getContainer()->get('doctrine.dbal.default_connection');

        //$emNe4j      = $this->getContainer()->get('neo4j.entity_manager.default');
        $neo4jClient = $this->getNeo4jClient();

        /**
         * Créations des centrales
         */
        $output->writeln("Créaction des centrales : ");
        $queryCentrale  = 'CREATE (c:Centrale {reacteur: {reacteur}, centrale:{centrale},  latitude:{latitude}, longitude:{longitude}})';


        $countCentrales = $emDoctrine
                            ->createQuery('SELECT COUNT(1) from CityFinderBundle\Entity\CentralesNucleaires c')
                            ->getSingleScalarResult();

        $queryCommunes = $emDoctrine->createQuery('select c from CityFinderBundle\Entity\CentralesNucleaires c');

        $progress = new ProgressBar($output, $countCentrales);
        $progress->setFormat('debug');

        $iterableResult = $queryCommunes->iterate();


        while (($centrale = $iterableResult->next()) !== false) {

            $neo4jClient->runWrite($queryCentrale,[
                'reacteur'      => $centrale[0]->getNomReacteur(),
                'centrale'      => $centrale[0]->getCentraleNucleaire(),
                'latitude'      => $centrale[0]->getLatitude(),
                'longitude'     => $centrale[0]->getLongitude()
            ]);

            $emDoctrine->clear();

            $progress->advance();
        }

        $progress->finish();
        unset($queryCommunes);






        /**
         * Création des communes
         */
        $output->writeln("Créaction des communes : ");

        // récupération du nombre de commune
        $countCommune   = $emDoctrine
                            ->createQuery('SELECT COUNT(1) from CityFinderBundle\Entity\DonneesCommunes c')
                            ->getSingleScalarResult();

        // création d'un noeud de commune
        $queryCreateNodeCommune   = 'CREATE (c:Commune {name:{localite}, latitude:{latitude}, longitude:{longitude}})';

        // création d'une liaison entre une commune et une centrale
        $queryCreateRelationshipCentraleCommune ='
            MATCH (c:Commune{name: {nom_commune}})
            MATCH (n:Centrale {reacteur:{nom_reacteur}}) 
            MERGE (c)-[:NEAR_30KM_FROM]->(n)';

        // communes ayants une centrale à proximité
        $queryCommuneCentrale = "
            SELECT 	commune.localite 			AS `commune`,
                    centrale.nom_reacteur		AS `reacteur`,
                    calcul_distance_kilometre(commune.latitude, commune.longitude, centrale.latitude, centrale.longitude) AS `Distance`
            FROM 	donnees_communes commune, 
                    centrales_nucleaires centrale
            WHERE 	commune.localite = :localite
            HAVING Distance <= :distance";

        $queryCommunes = $emDoctrine->createQuery('select c from CityFinderBundle\Entity\DonneesCommunes c');

        $progress = new ProgressBar($output, $countCommune);
        $progress->setFormat('debug');


        $iterableResult = $queryCommunes->iterate();

        while (($next = $iterableResult->next()) !== false) {

            $commune = $next[0];

            $stmtAProximiteCentrale = $connectionDoctrine->prepare($queryCommuneCentrale);
            $stmtAProximiteCentrale->execute([
                'localite'  =>$commune->getLocalite(),
                'distance'  => 30
            ]);



            //création de la commune
            $neo4jClient->runWrite($queryCreateNodeCommune,[
                'localite'      => $commune->getLocalite(),
                'latitude'      => $commune->getLatitude(),
                'longitude'     => $commune->getLongitude()
            ]);

            //création de la relation entre une commune et une centrale
            foreach ($stmtAProximiteCentrale->fetchAll(PDO::FETCH_NAMED) as $information) {
                //dump($information);

                //création de la relation centrale commune
                $neo4jClient->runWrite($queryCreateRelationshipCentraleCommune,[
                    'nom_commune'      => $information["commune"],
                    'nom_reacteur'     => $information["reacteur"]
                ]);



            }


            $emDoctrine->clear();

            $progress->advance();
            //die('test');
        }

        $progress->finish();
        $output->writeln("");
    }

    /**
     * @return \GraphAware\Neo4j\Client\Client
     */
    private function getNeo4jClient()
    {
        return $this->getContainer()->get('neo4j.client');
    }

    /**
     * @return \Doctrine\Bundle\DoctrineBundle\Registry
     */
    private function getDoctrineClient()
    {
        return $this->getContainer()->get('doctrine');
    }

    private function degresToRadians ($degre) {
        return (($degre * pi()) / 180);
    }

    private function distance($latitudeA, $longitudeA, $latitudeB, $longitudeB) {
        return 	6371 * acos(
                sin(degres_to_radian($latitudeA)) * sin(degres_to_radian($latitudeB)) +
                COS(degres_to_radian($latitudeA)) * COS(degres_to_radian($latitudeB)) * COS (degres_to_radian($longitudeB) - degres_to_radian($longitudeA))
            );
    }

    private function convert($size)
    {
        $unit=array('b','kb','mb','gb','tb','pb');
        return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
    }

}