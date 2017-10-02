<?php
namespace CityFinderBundle\Command;


use CityFinderBundle\Entity\Communes;
use CityFinderBundle\Utils\ServicesTraits;
use PDO;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LoadCentralesCommand extends ContainerAwareCommand
{
    use ServicesTraits;

    protected function configure()
    {
        $this
            ->setName('cityfinder:load:centrales')
            ->setDescription('Doctrine Centrales to neo4j Centrales')
            ->setHelp('Doctrine Communes to neo4j Commune');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $doctrine           = $this->getDoctrineClient();
        $emDoctrine         = $doctrine->getManager();
        $neo4jClient        = $this->getNeo4jClient();


        /**
         * Créations des centrales
         */
        $output->writeln("Créaction des centrales : ");

        // Requête de récupération du nombre de commune
        $countCentrales   = $emDoctrine
            ->createQuery('SELECT COUNT(1) from CityFinderBundle\Entity\Centrales c')
            ->getSingleScalarResult();

        if ($countCentrales > 0) {
            //requête permettant de créer un noeud neo4j pour les centrales
            $queryCreateNodeCentrale  = 'CREATE (c:Centrale {name:{centrale}, nombreReacteur: {reacteur}, doctrineId:{doctrineId}})';

            //récupération des centrales doctrines
            $queryCentrales = $emDoctrine->createQuery('select c from CityFinderBundle\Entity\Centrales c');

            //création de la  barre de progression
            $progress = new ProgressBar($output, $countCentrales);
            $progress->setFormat('debug');

            $iterableResult = $queryCentrales->iterate();

            foreach ($iterableResult as $centrale) {

                //création de la commune
                $neo4jClient->runWrite($queryCreateNodeCentrale,[
                    'doctrineId'    => $centrale[0]->getId(),
                    'reacteur'      => $centrale[0]->getNombreReacteur(),
                    'centrale'      => $centrale[0]->getNom(),
                ]);

                $emDoctrine->clear();

                $progress->advance();

            }
            $progress->finish();
            $output->writeln("");



            unset($progress);


        }
        else {
            $output->writeln("Aucune Centrales dans doctrine :(");
            return;
        }






        // récupération du nombre de commune
        $countCommune   = $emDoctrine
            ->createQuery('SELECT COUNT(1) from CityFinderBundle\Entity\Communes c')
            ->getSingleScalarResult();

        // création d'une liaison entre une commune et une centrale
        $queryCreateRelationshipCentraleCommune20 ='
            MATCH (c:Commune {doctrineId: {communeDoctrineId}})
            MATCH (n:Centrale {doctrineId: {centraleDoctrineId}}) 
            CREATE (c)-[:NEAR_20KM_FROM]->(n)';

        $queryCreateRelationshipCentraleCommune30 ='
            MATCH (c:Commune {doctrineId: {communeDoctrineId}})
            MATCH (n:Centrale {doctrineId: {centraleDoctrineId}}) 
            CREATE (c)-[:NEAR_30KM_FROM]->(n)';

        $queryCreateRelationshipCentraleCommune80 ='
            MATCH (c:Commune {doctrineId: {communeDoctrineId}})
            MATCH (n:Centrale {doctrineId: {centraleDoctrineId}}) 
            CREATE (c)-[:NEAR_80KM_FROM]->(n)';

        // communes ayants une centrale à proximité
        $queryCommuneCentrale = "
            SELECT 	communes.id 	  AS `commune_id`,
                    centrales.id	  AS `centrale_id`,
                    calcul_distance_kilometre(communes.latitude, communes.longitude, centrales.latitude, centrales.longitude) AS `distance`
            FROM 	communes, 
                    centrales
            WHERE 	communes.id = :communeId";

        $queryCommunes = $emDoctrine->createQuery('select c from CityFinderBundle\Entity\Communes c');

        $progress = new ProgressBar($output, $countCommune);
        $progress->setFormat('debug');


        $iterableResult = $queryCommunes->iterate();

        while (($next = $iterableResult->next()) !== false) {

            /**
             * @var Communes $commune
             */
            $commune = $next[0];


            $stmtAProximiteCentrale = $doctrine->getConnection()->prepare($queryCommuneCentrale);
            $stmtAProximiteCentrale->execute([
                'communeId'   => $commune->getId(),
            ]);

            //création de la relation entre une commune et une centrale
            foreach ($stmtAProximiteCentrale->fetchAll(PDO::FETCH_NAMED) as $information) {

                if (intval($information['distance']) <= 20) {
                    //création de la relation centrale commune
                    $neo4jClient->runWrite($queryCreateRelationshipCentraleCommune20, [
                        'communeDoctrineId' => intval($information['commune_id']),
                        'centraleDoctrineId' => intval($information['centrale_id'])
                    ]);
                }
                if (intval($information['distance']) <= 30) {
                    //création de la relation centrale commune
                    $neo4jClient->runWrite($queryCreateRelationshipCentraleCommune30, [
                        'communeDoctrineId' => intval($information['commune_id']),
                        'centraleDoctrineId' => intval($information['centrale_id'])
                    ]);
                }
                if (intval($information['distance']) <= 80) {
                    //création de la relation centrale commune
                    $neo4jClient->runWrite($queryCreateRelationshipCentraleCommune80, [
                        'communeDoctrineId' => intval($information['commune_id']),
                        'centraleDoctrineId' => intval($information['centrale_id'])
                    ]);
                }
            }

            $emDoctrine->clear();

            $progress->advance();

        }
        $progress->finish();
        $output->writeln("");
        $output->writeln("<info>Terminé</info>");
    }
}