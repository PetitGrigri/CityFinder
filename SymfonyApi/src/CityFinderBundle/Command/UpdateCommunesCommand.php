<?php
namespace CityFinderBundle\Command;

use CityFinderBundle\Entity\Communes;
use CityFinderBundle\Utils\ServicesCommandTraits;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateCommunesCommand extends ContainerAwareCommand
{
    use ServicesCommandTraits;

    protected function configure()
    {
        $this
            ->setName('cityfinder:update:communes')
            ->setDescription('Doctrine Communes to neo4j Commune')
            ->setHelp('Doctrine Communes to neo4j Commune')
            ->addOption('with-merge', null, InputOption::VALUE_NONE, 'Allow to merge new data into Node');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $doctrine           = $this->getDoctrineClient();
        $emDoctrine         = $doctrine->getManager();
        $neo4jClient        = $this->getNeo4jClient();

        /**
         * Création des communes
         */
        $output->writeln("Chargement des communes en mémoire : ");

        // Requête de récupération du nombre de commune
        $countCommune   = $emDoctrine
            ->createQuery('SELECT COUNT(1) from CityFinderBundle\Entity\Communes c')
            ->getSingleScalarResult();

        //si on a des communes on continue
        if ($countCommune > 0) {

            //récupération des Communes docitrnes
            $queryCommunes = $emDoctrine->createQuery('select c from CityFinderBundle\Entity\Communes c');

            //compteur de commune (les ids ne sont peut être pas tous à la suite
            $i = 0;

            //création de la  barre de progression
            $progress = new ProgressBar($output, $countCommune);
            $progress->setFormat('debug');

            // Desctruction du nombre de commubes
            unset($countCommune);

            $iterableResult = $queryCommunes->iterate();

            //stockage des données des communes en ram
            $donneesCommunes = [];


            foreach ($iterableResult as $next) {
                /**
                 * @var Communes $communeDoctrine
                 */
                $communeDoctrine = $next[0];

                $donneesCommunes[++$i] = [
                    'lat'   => $communeDoctrine->getLatitude(),
                    'long'  => $communeDoctrine->getLongitude(),
                    'id'    => $communeDoctrine->getId(),
                ];


                $emDoctrine->clear();
                $progress->advance();

            }
            $progress->finish();
            $output->writeln("");
            $output->writeln("<info>Terminé</info>");


            unset($doctrine, $progress, $emDoctrine);


            $nbCommunes = count($donneesCommunes);

            //création de la  barre de progression
            $progress = new ProgressBar($output, ($nbCommunes+1)*((0+$nbCommunes)/2));
            $progress->setFormat('debug');


            $query2km   = 'MATCH (c1:Commune) MATCH (c2:Commune) WHERE c1.doctrineId ={idC1} AND c2.doctrineId ={idC2} MERGE (c1)<-[:NEAR_2KM_FROM]-(c2) MERGE (c1)-[:NEAR_2KM_FROM]->(c2)';
            $query5km   = 'MATCH (c1:Commune) MATCH (c2:Commune) WHERE c1.doctrineId ={idC1} AND c2.doctrineId ={idC2} MERGE (c1)<-[:NEAR_5KM_FROM]-(c2) MERGE (c1)-[:NEAR_5KM_FROM]->(c2)';
            $query10km  = 'MATCH (c1:Commune) MATCH (c2:Commune) WHERE c1.doctrineId ={idC1} AND c2.doctrineId ={idC2} MERGE (c1)<-[:NEAR_10KM_FROM]-(c2) MERGE (c1)-[:NEAR_10KM_FROM]->(c2)';

            for ($a = 1; $a < $nbCommunes; $a++) {
                for ($b = ($a + 1); $b< $nbCommunes; $b++) {
                    $progress->advance();
                    $distance = intval($this->calculDistance($donneesCommunes[$a]['lat'], $donneesCommunes[$a]['long'],
                        $donneesCommunes[$b]['lat'], $donneesCommunes[$b]['long']));


                    if ($distance <= 2) {
                        $neo4jClient->runWrite($query2km, [
                            'idC1' => $donneesCommunes[$a]['id'],
                            'idC2' => $donneesCommunes[$b]['id'],
                        ]);
                    }
                    else if ($distance <= 5) {
                        $neo4jClient->runWrite($query5km, [
                            'idC1' => $donneesCommunes[$a]['id'],
                            'idC2' => $donneesCommunes[$b]['id'],
                        ]);
                    }
                    else if ($distance <= 10) {
                        $neo4jClient->runWrite($query10km, [
                            'idC1' => $donneesCommunes[$a]['id'],
                            'idC2' => $donneesCommunes[$b]['id'],
                        ]);
                    }
                }
                $output->writeln($a);

            }

            $progress->finish();
            $output->writeln("");
            $output->writeln("<info>Terminé</info>");

        }
        else {
            $output->writeln("<error>Aucune Commune dans doctrine</error>");
        }
    }


    private function calculDistance($latitudeA, $longitudeA, $latitudeB, $longitudeB) {
        $degreeLatitudeA    = $this->calculToRadian($latitudeA);
        $degreeLongitudeA   = $this->calculToRadian($longitudeA);
        $degreeLatitudeB    = $this->calculToRadian($latitudeB);
        $degreeLongitudeB   = $this->calculToRadian($longitudeB);

        return 6371 * acos(
                sin($degreeLatitudeA) * sin($degreeLatitudeB) +
                cos($degreeLatitudeA) * cos($degreeLatitudeB) * cos ($degreeLongitudeB - $degreeLongitudeA)
            );

    }

    private function calculToRadian($degree) {
        return (($degree * pi()) / 180);
    }

}