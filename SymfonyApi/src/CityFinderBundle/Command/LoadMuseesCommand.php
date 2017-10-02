<?php
namespace CityFinderBundle\Command;


use CityFinderBundle\Entity\Communes;
use CityFinderBundle\Entity\Musees;
use CityFinderBundle\Node\Commune;
use CityFinderBundle\Utils\ServicesTraits;
use PDO;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LoadMuseesCommand extends ContainerAwareCommand
{
    use ServicesTraits;

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
            $output->writeln("Aucune Musees dans doctrine :(");
            return;
        }




        /**
         * Ajout des relations entre les musees et les communes
         */
        $output->writeln("Ajout des relations entre les musees et les commmunes : ");


        // récupération du nombre de commune
        $countCommune   = $emDoctrine
            ->createQuery('SELECT COUNT(1) from CityFinderBundle\Entity\Communes c')
            ->getSingleScalarResult();

        //si on a des communes, on peut commncer le remplissage
        if ($countCommune > 0) {
            //création de la barre de progression
            $progress = new ProgressBar($output, ($countMusees));
            $progress->setFormat('debug');

            unset ($countCommune, $countMusees);

            //requête permettant de récupérer la commune ou se situe l'musee

            $requeteMuseeCommune ="
                SELECT 	musees.id AS musee_id,
                        communes_musees.id AS commune_id,
                        musees.musee AS musee_nom,
                        correspondance_communes.insee AS musee__commune_insee, 
                        musees.localite AS musee_localite,
                        correspondance_communes.nom  AS commune_nom
                FROM musees
                JOIN correspondance_communes 
                    ON musees.postal = correspondance_communes.postal
                JOIN communes AS communes_musees
                    ON communes_musees.insee = correspondance_communes.insee
                WHERE musees.id = :museeId";

            $queryCreateRelationshipMuseeCommune ='
                MATCH (c:Commune {doctrineId: {communeDoctrineId}})
                MATCH (h:Musee {doctrineId: {museeDoctrineId}}) 
                MERGE (c)<-[:LOCATED_IN]-(h)';

            $queryCreateRelationshipMuseeCommuneNear ='
                MATCH (c:Commune {doctrineId: {communeDoctrineId}})
                MATCH (h:Musee {doctrineId: {museeDoctrineId}}) 
                MERGE (c)<-[:NEAR]-(h)';

            //les requêtes communes et musees
            $queryMusees    = $emDoctrine->createQuery('select c from CityFinderBundle\Entity\Musees c');
            $iterableMusees = $queryMusees->iterate();


            //parsing des musees
            while (($next = $iterableMusees->next()) !== false) {
                /**
                 * @var Musees $musee
                 */
                $musee = $next[0];

                $stmtAProximiteCentrale = $doctrine->getConnection()->prepare($requeteMuseeCommune);
                $stmtAProximiteCentrale->execute([
                    'museeId'   => $musee->getId(),
                ]);

                $informations = $stmtAProximiteCentrale->fetchAll(PDO::FETCH_NAMED);

                foreach ($informations as $information) {
                    if ((count($informations) == 1) || ($information["musee_localite"] == $information["commune_nom"])) {
                        //création de la relation musee dans la commune
                        $neo4jClient->runWrite($queryCreateRelationshipMuseeCommune, [
                            'communeDoctrineId' => intval($information['commune_id']),
                            'museeDoctrineId' => intval($information['musee_id'])
                        ]);
                    } else {
                        //création de la relation musee pret de la commune
                        $neo4jClient->runWrite($queryCreateRelationshipMuseeCommuneNear, [
                            'communeDoctrineId' => intval($information['commune_id']),
                            'museeDoctrineId' => intval($information['musee_id'])
                        ]);
                    }
                }

                unset($informations, $information, $stmtAProximiteCentrale);
                $emDoctrine->clear();
                $progress->advance();
            }
        }
        $progress->finish();
        $output->writeln("");
        $output->writeln("<info>Terminé</info>");
    }
}