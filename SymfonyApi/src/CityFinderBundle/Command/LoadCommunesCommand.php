<?php
namespace CityFinderBundle\Command;

use CityFinderBundle\Entity\Communes;
use CityFinderBundle\Utils\ServicesCommandTraits;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class LoadCommunesCommand extends ContainerAwareCommand
{
    use ServicesCommandTraits;

    protected function configure()
    {
        $this
            ->setName('cityfinder:load:communes')
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
        $output->writeln("Création des communes : ");

        // Requête de récupération du nombre de commune
        $countCommune   = $emDoctrine
            ->createQuery('SELECT COUNT(1) from CityFinderBundle\Entity\Communes c')
            ->getSingleScalarResult();

        //si on a des communes on continue
        if ($countCommune > 0) {
            if (!$input->getOption('with-merge')) {
                // Requête de création son prendre en compte s'ils existent déjà (initialisation)
                $queryCreateNodeCommune = '   CREATE (  c:Commune {name:{nom}, 
                                                        codeRegion:{codeRegion}, 
                                                        nomRegion:{nomRegion}, 
                                                        codeDepartement:{codeDepartement},
                                                        nomDepartement:{nomDepartement},
                                                        c.frWikipedia = {frWikipedia},
                                                        doctrineId:{doctrineId}})';
            } else {
                // Requête de création en prennant en compte leur existance
                $queryCreateNodeCommune = '   MERGE (c:Commune {doctrineId:{doctrineId}}) 
                                              SET   c.name = {nom},
                                                    c.codeRegion = {codeRegion},
                                                    c.nomRegion = {nomRegion},
                                                    c.codeDepartement = {codeDepartement},
                                                    c.frWikipedia = {frWikipedia},
                                                    c.nomDepartement = {nomDepartement}';
            }

            //récupération des Communes docitrnes
            $queryCommunes = $emDoctrine->createQuery('select c from CityFinderBundle\Entity\Communes c');

            //création de la  barre de progression
            $progress = new ProgressBar($output, $countCommune);
            $progress->setFormat('debug');

            // Desctruction du nombre de commubes
            unset($countCommune);

            $iterableResult = $queryCommunes->iterate();

            foreach ($iterableResult as $next) {
               /**
                * @var Communes $communeDoctrine
                */
                $communeDoctrine = $next[0];


                //création de la commune
                $neo4jClient->runWrite($queryCreateNodeCommune,[
                    'doctrineId'        => $communeDoctrine->getId(),
                    'nom'               => $communeDoctrine->getNom(),
                    'nomRegion'         => $communeDoctrine->getNomRegion(),
                    'codeRegion'        => $communeDoctrine->getCodeReg(),
                    'nomDepartement'    => $communeDoctrine->getNomDept(),
                    'codeDepartement'   => $communeDoctrine->getCodeDept(),
                    'frWikipedia'       => str_replace("fr:", "",$communeDoctrine->getWikipedia()),
                ]);

                $emDoctrine->clear();

                $progress->advance();

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