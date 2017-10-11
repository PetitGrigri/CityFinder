<?php
namespace CityFinderBundle\Command;


use CityFinderBundle\Entity\Communes;
use CityFinderBundle\Entity\Musees;
use CityFinderBundle\Node\Commune;
use CityFinderBundle\Utils\ServicesCommandTraits;
use PDO;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LoadMuseesCommand extends ContainerAwareCommand
{
    use ServicesCommandTraits;

    protected function configure()
    {
        $this
            ->setName('cityfinder:load:musees')
            ->setDescription('Doctrine Musees to neo4j Musees')
            ->setHelp('Doctrine Musees to neo4j Commune');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $doctrine           = $this->getDoctrineClient();
        $emDoctrine         = $doctrine->getManager();
        $neo4jClient        = $this->getNeo4jClient();


        /**
         * Créations des centrales
         */
        $output->writeln("Créaction des musees : ");

        // Requête de récupération du nombre de commune
        $countMusees   = $emDoctrine
            ->createQuery('SELECT COUNT(1) from CityFinderBundle\Entity\Musees c')
            ->getSingleScalarResult();


        if ($countMusees > 0) {
            //requête permettant de créer un noeud neo4j pour les centrales
            $queryCreateNodeMusee  = 'CREATE (h:Musee {name:{nom}, doctrineId:{doctrineId}})';

            //récupération des centrales doctrines
            $queryMusees = $emDoctrine->createQuery('select c from CityFinderBundle\Entity\Musees c');

            //création de la  barre de progression
            $progress = new ProgressBar($output, $countMusees);
            $progress->setFormat('debug');

            $iterableResult = $queryMusees->iterate();

            foreach ($iterableResult as $musee) {

                //création du musee
                $neo4jClient->runWrite($queryCreateNodeMusee,[
                    'doctrineId'    => $musee[0]->getId(),
                    'nom'           => $musee[0]->getMusee(),
                ]);

                $emDoctrine->clear();
                $progress->advance();

            }
            $progress->finish();
            $output->writeln("");

            unset($progress, $queryMusees, $iterableResult);
        }
        else {
            $output->writeln("Aucun Musée");
            return;
        }




        /**
         * Ajout des relations entre les musees et les communes
         */
        $output->writeln("Ajout des relations entre les musees et les commmunes : ");

        //unset ($countCommune, $countMusees);

        //requête permettant de récupérer la commune ou se situe l'musee

        $requeteMuseeCommuneCount ="
            SELECT 	count(1) as total_row
            FROM (	SELECT 	musees.id 		AS musee_id,
                            musees.musee 	AS musee_nom,
                            musees.localite AS musee_localite,
                            correspondance_communes.insee 	AS musee_commune_insee, 
                            correspondance_communes.nom  	AS commune_nom,
                            correspondance_communes.insee  	AS insee
                    FROM musees
                    JOIN correspondance_communes 
                        ON musees.postal = correspondance_communes.postal)  mcc
            JOIN communes AS communes_musees
                ON communes_musees.insee = mcc.insee";

        $requeteMuseeCommune ="
            SELECT 	mcc.musee_id,
                    mcc.musee_nom, 
                    mcc.musee_commune_insee, 
                    mcc.musee_localite, 
                    mcc.musees_postal,
                    GROUP_CONCAT(communes_musees.id) AS communes_ids,
                    GROUP_CONCAT(mcc.commune_nom) AS communes,
                    COUNT(1) AS total_commune_musee
            FROM (	SELECT 	musees.id 		AS musee_id,
                            musees.musee 	AS musee_nom,
                            musees.localite AS musee_localite,
                            musees.postal AS musees_postal,
                            correspondance_communes.insee 	AS musee_commune_insee, 
                            correspondance_communes.nom  	AS commune_nom,
                            correspondance_communes.insee  	AS insee
                    FROM musees
                    JOIN correspondance_communes 
                        ON musees.postal = correspondance_communes.postal)  mcc
            JOIN communes AS communes_musees
                ON communes_musees.insee = mcc.insee
            GROUP BY mcc.musee_id";

        $queryCreateRelationshipMuseeCommune ='
            MATCH (c:Commune {doctrineId: {communeDoctrineId}})
            MATCH (h:Musee {doctrineId: {museeDoctrineId}}) 
            MERGE (c)<-[:LOCATED_IN]-(h)';

        $queryCreateRelationshipMuseeCommuneNear ='
            MATCH (c:Commune {doctrineId: {communeDoctrineId}})
            MATCH (h:Musee {doctrineId: {museeDoctrineId}}) 
            MERGE (c)<-[:NEAR]-(h)';



        $stmtCountCommuneMusees = $doctrine->getConnection()->prepare($requeteMuseeCommuneCount);
        $stmtCountCommuneMusees->execute();
        $rowCount = $stmtCountCommuneMusees->fetch();

        if ($rowCount) {

            $progress = new ProgressBar($output, $rowCount['total_row']);
            $progress->setFormat('debug');

            unset ($stmtCountCommuneMusees, $rowCount, $rowCount);

            $stmtCommuneMusees = $doctrine->getConnection()->prepare($requeteMuseeCommune);
            $stmtCommuneMusees->execute();

            while($row = $stmtCommuneMusees->fetch(PDO::FETCH_NAMED)) {

                $communesArray      = explode(',',$row['communes']);
                $communeIdsArray    = explode(',',$row['communes_ids']);
                $i=0;

                foreach ($communesArray as $commune) {
                    if ((intval($row['total_commune_musee']) == 1 ) || ($commune == $row['musee_localite'])) {
                        $neo4jClient->runWrite($queryCreateRelationshipMuseeCommune, [
                            'communeDoctrineId' => intval($communeIdsArray[$i]),
                            'museeDoctrineId' => intval($row['musee_id'])
                        ]);
                    } else {
                        $neo4jClient->runWrite($queryCreateRelationshipMuseeCommuneNear, [
                            'communeDoctrineId' => intval($communeIdsArray[$i]),
                            'museeDoctrineId' => intval($row['musee_id'])
                        ]);
                    }
                    $i++;
                    $progress->advance();
                }
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