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
        //$memcached           = $this->getMemCachedAdapter();

        /**
         * Création des communes
         */
        $output->writeln("Chargement des communes dans memecached : ");

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
                    "lat" => $communeDoctrine->getLatitude(),
                    "long" => $communeDoctrine->getLongitude(),
                    "id" => $communeDoctrine->getId(),
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




            for ($a = 1; $a < $nbCommunes; $a++) {
                for ($b = ($a + 1); $b< $nbCommunes; $b++) {
                    $progress->advance();
                }
            }

            $progress->finish();
            $output->writeln("");
            $output->writeln("<info>Terminé</info>");

        }
        else {
            $output->writeln("<error>Aucune Commune dans doctrine</error>");
        }
    }
}