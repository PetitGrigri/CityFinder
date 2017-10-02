<?php
namespace CityFinderBundle\Command;


use CityFinderBundle\Entity\Communes;
use CityFinderBundle\Entity\Postes;
use CityFinderBundle\Node\Commune;
use CityFinderBundle\Utils\ServicesTraits;
use PDO;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LoadAgencesPostalesCommand extends ContainerAwareCommand
{
    use ServicesTraits;

    protected function configure()
    {
        $this
            ->setName('cityfinder:load:postes')
            ->setDescription('Doctrine Postes to neo4j Postes')
            ->setHelp('Doctrine AgencePostale to neo4j AgencePostale');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $doctrine           = $this->getDoctrineClient();
        $emDoctrine         = $doctrine->getManager();
        $neo4jClient        = $this->getNeo4jClient();


        /**
         * Créations des centrales
         */
        $output->writeln("Créaction des postes : ");

        // Requête de récupération du nombre de commune
        $countPostes   = $emDoctrine
            ->createQuery('SELECT COUNT(1) from CityFinderBundle\Entity\AgencesPostales c')
            ->getSingleScalarResult();


        if ($countPostes > 0) {
            //requête permettant de créer un noeud neo4j pour les centrales
            $queryCreateNodePoste  = 'CREATE (p:AgencePostale {name:{nom}, caracteristiqueSite:{caracteristiqueSite}, doctrineId:{doctrineId}})';

            //récupération des centrales doctrines
            $queryPostes = $emDoctrine->createQuery('select c from CityFinderBundle\Entity\AgencesPostales c');

            //création de la  barre de progression
            $progress = new ProgressBar($output, $countPostes);
            $progress->setFormat('debug');

            $iterableResult = $queryPostes->iterate();

            foreach ($iterableResult as $poste) {

                //création du poste
                $neo4jClient->runWrite($queryCreateNodePoste,[
                    'doctrineId'            => $poste[0]->getId(),
                    'nom'                   => $poste[0]->getLibelleSite(),
                    'caracteristiqueSite'   => $poste[0]->getCaracteristiqueSite(),
                ]);

                $emDoctrine->clear();
                $progress->advance();

            }
            $progress->finish();
            $output->writeln("");

            unset($progress, $queryPostes, $iterableResult);
        }
        else {
            $output->writeln("Aucune Agence Postale");
            return;
        }


        /**
         * Ajout des relations entre les postes et les communes
         */
        $output->writeln("Ajout des relations entre les postes et les commmunes : ");

        unset ($countPostes);

        //requête permettant de récupérer la commune ou se situe la poste, et la poste
        $requetePosteCommuneCount ="
            SELECT 	count(1) as total_row
            FROM 	agences_postales
            JOIN communes
                ON communes.insee = agences_postales.code_INSEE";


        $requetePosteCommune ="
            SELECT 	agences_postales.id AS poste_id,
                    communes.id         AS commune_id
            FROM 	agences_postales
            JOIN communes
                ON communes.insee = agences_postales.code_INSEE";

        $queryCreateRelationshipPosteCommune ='
            MATCH (c:Commune {doctrineId: {communeDoctrineId}})
            MATCH (p:AgencePostale {doctrineId: {posteDoctrineId}}) 
            MERGE (c)<-[:LOCATED_IN]-(p)';

        $stmtCountCommunePostes = $doctrine->getConnection()->prepare($requetePosteCommuneCount);
        $stmtCountCommunePostes->execute();
        $rowCount = $stmtCountCommunePostes->fetch();

        if ($rowCount) {

            $progress = new ProgressBar($output, $rowCount['total_row']);
            $progress->setFormat('debug');

            unset ($stmtCountCommunePostes, $rowCount);

            $stmtCommunePostes = $doctrine->getConnection()->prepare($requetePosteCommune);
            $stmtCommunePostes->execute();

            while($row = $stmtCommunePostes->fetch(PDO::FETCH_NAMED)) {

                $neo4jClient->runWrite($queryCreateRelationshipPosteCommune, [
                    'communeDoctrineId' => intval($row['commune_id']),
                    'posteDoctrineId' => intval($row['poste_id'])
                ]);

                $progress->advance();
            }

            $progress->finish();
            $output->writeln("");
            $output->writeln("<info>Terminé</info>");
        } else {
            $output->writeln("Aucune relation trouvée :(");
            return;
        }
    }
}