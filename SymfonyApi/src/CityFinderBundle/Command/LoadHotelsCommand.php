<?php
namespace CityFinderBundle\Command;


use CityFinderBundle\Entity\Communes;
use CityFinderBundle\Entity\Hotels;
use CityFinderBundle\Node\Commune;
use CityFinderBundle\Utils\ServicesCommandTraits;
use PDO;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LoadHotelsCommand extends ContainerAwareCommand
{
    use ServicesCommandTraits;

    protected function configure()
    {
        $this
            ->setName('cityfinder:load:hotels')
            ->setDescription('Doctrine Hotels to neo4j Hotels')
            ->setHelp('Doctrine Hotels to neo4j Commune');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $doctrine           = $this->getDoctrineClient();
        $emDoctrine         = $doctrine->getManager();
        $neo4jClient        = $this->getNeo4jClient();


        /**
         * Créations des centrales
         */
        $output->writeln("Créaction des hotels : ");

        // Requête de récupération du nombre de commune
        $countHotels   = $emDoctrine
            ->createQuery('SELECT COUNT(1) from CityFinderBundle\Entity\Hotels c')
            ->getSingleScalarResult();


        if ($countHotels > 0) {
            //requête permettant de créer un noeud neo4j pour les centrales
            $queryCreateNodeHotel  = 'CREATE (h:Hotel {name:{nom}, classement: {classement}, doctrineId:{doctrineId}})';

            //récupération des centrales doctrines
            $queryHotels = $emDoctrine->createQuery('select c from CityFinderBundle\Entity\Hotels c');

            //création de la  barre de progression
            $progress = new ProgressBar($output, $countHotels);
            $progress->setFormat('debug');

            $iterableResult = $queryHotels->iterate();

            foreach ($iterableResult as $hotel) {

                //création de l'hotel
                $neo4jClient->runWrite($queryCreateNodeHotel,[
                    'doctrineId'    => $hotel[0]->getId(),
                    'classement'    => $hotel[0]->getClassement(),
                    'nom'           => $hotel[0]->getNomCommercial(),
                ]);

                $emDoctrine->clear();

                $progress->advance();

            }
            $progress->finish();
            $output->writeln("");

            unset($progress, $queryHotels, $iterableResult);
        }
        else {
            $output->writeln("Aucune Hotels dans doctrine :(");
            return;
        }




        /**
         * Ajout des relations entre les hotels et les communes
         */
        $output->writeln("Ajout des relations entre les hotels et les commmunes : ");


        // récupération du nombre de commune
        $countCommune   = $emDoctrine
            ->createQuery('SELECT COUNT(1) from CityFinderBundle\Entity\Communes c')
            ->getSingleScalarResult();

        //si on a des communes, on peut commncer le remplissage
        if ($countCommune > 0) {
            //création de la barre de progression
            $progress = new ProgressBar($output, ($countHotels));
            $progress->setFormat('debug');

            unset ($countCommune, $countHotels);

            //requête permettant de récupérer la commune ou se situe l'hotel

            $requeteHotelCommune ="
                SELECT 	hotels.id AS hotel_id,
                        communes_hotels.id AS commune_id,
                        hotels.nom_commercial AS hotel_nom,
                        correspondance_communes.insee AS hotel__commune_insee, 
                        communes_hotels.latitude AS hotel_latitude, 
                        communes_hotels.longitude AS hotel_longitude,
                        hotels.localite AS hotel_localite,
                        correspondance_communes.nom  AS commune_nom
                FROM hotels
                JOIN correspondance_communes 
                    ON hotels.code_postal = correspondance_communes.postal
                JOIN communes AS communes_hotels
                    ON communes_hotels.insee = correspondance_communes.insee
                WHERE hotels.id = :hotelId";

            $queryCreateRelationshipHotelCommune ='
                MATCH (c:Commune {doctrineId: {communeDoctrineId}})
                MATCH (h:Hotel {doctrineId: {hotelDoctrineId}}) 
                MERGE (c)<-[:LOCATED_IN]-(h)';

            $queryCreateRelationshipHotelCommuneNear ='
                MATCH (c:Commune {doctrineId: {communeDoctrineId}})
                MATCH (h:Hotel {doctrineId: {hotelDoctrineId}}) 
                MERGE (c)<-[:NEAR]-(h)';

            //les requêtes communes et hotels
            $queryHotels    = $emDoctrine->createQuery('select c from CityFinderBundle\Entity\Hotels c');
            $iterableHotels = $queryHotels->iterate();


            //parsing des hotels
            while (($nextH = $iterableHotels->next()) !== false) {
                /**
                 * @var Hotels $hotel
                 */
                $hotel = $nextH[0];

                $stmtAProximiteCentrale = $doctrine->getConnection()->prepare($requeteHotelCommune);
                $stmtAProximiteCentrale->execute([
                    'hotelId'   => $hotel->getId(),
                ]);

                $informations = $stmtAProximiteCentrale->fetchAll(PDO::FETCH_NAMED);

                foreach ($informations as $information) {
                    if ((count($informations) == 1) || ($information["hotel_localite"] == $information["commune_nom"])) {
                        //création de la relation hotel dans la commune
                        $neo4jClient->runWrite($queryCreateRelationshipHotelCommune, [
                            'communeDoctrineId' => intval($information['commune_id']),
                            'hotelDoctrineId' => intval($information['hotel_id'])
                        ]);
                    } else {
                        //création de la relation hotel pret de la commune
                        $neo4jClient->runWrite($queryCreateRelationshipHotelCommuneNear, [
                            'communeDoctrineId' => intval($information['commune_id']),
                            'hotelDoctrineId' => intval($information['hotel_id'])
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