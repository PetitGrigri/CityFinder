<?php
namespace CityFinderBundle\Command;

use CityFinderBundle\Entity\Communes;
use CityFinderBundle\Entity\CorrespondanceCommunes;
use CityFinderBundle\Utils\ServicesTraits;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateCorrespondanceCommunesCommand extends ContainerAwareCommand
{
    use ServicesTraits;
    const TAILLE_CODE_POSTAL = 5;

    protected function configure()
    {
        $this
            ->setName('cityfinder:update:correspondances')
            ->setDescription('Update CorrespondanceCommunes Entity')
            ->setHelp('Update CorrespondancesCommunes Entity for having one postal code and not multiple for specific cities');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $doctrine           = $this->getDoctrineClient();
        $emDoctrine         = $doctrine->getManager();

        /**
         * Création des communes
         */
        $output->writeln("Création des communes : ");

        // Requête de récupération des correspondances ayant plusieurs code postal pour le même code insee
        // (le codepostal est séparé par un /
        $countCorrespondanceMultiple   = $emDoctrine
            ->createQuery(' 
                SELECT  COUNT(1)
                FROM    CityFinderBundle\Entity\CorrespondanceCommunes cc 
                WHERE   length(cc.postal) > :taille_code_postal_normale')
            ->setParameter('taille_code_postal_normale', self::TAILLE_CODE_POSTAL)->getSingleScalarResult();


        //création de la  barre de progression
        $progress = new ProgressBar($output, $countCorrespondanceMultiple);
        $progress->setFormat('debug');


        $correspondancesMultiplesQuery   = $emDoctrine
            ->createQuery(' 
                SELECT  cc 
                FROM    CityFinderBundle\Entity\CorrespondanceCommunes cc 
                WHERE   length(cc.postal) > :taille_code_postal_normale')
            ->setParameter('taille_code_postal_normale', self::TAILLE_CODE_POSTAL);


        $compteurAjout = 0;

        $iterableResult = $correspondancesMultiplesQuery->iterate();

        foreach ($iterableResult as $next) {
            /**
             * @var CorrespondanceCommunes $correspondanceCommune
             */
            $correspondanceCommune  = $next[0];

            $codePostaux            = explode('/', $correspondanceCommune->getPostal());


            foreach ($codePostaux as $codePostal) {
                //on clone la ligne, la détachons de doctrine et on modifie le code postal
                $correspondanceCommuneDuplicated = clone $correspondanceCommune;
                $emDoctrine->detach($correspondanceCommuneDuplicated);
                $correspondanceCommuneDuplicated->setPostal($codePostal);

                //sauvegarde de la nouvelle ligne dupliquée (vu qu'elle est détachée, ca en créera une nouvelle)
                $emDoctrine->persist($correspondanceCommuneDuplicated);
                $emDoctrine->flush();
                $compteurAjout++;
            }
            $emDoctrine->remove($correspondanceCommune);
            $emDoctrine->flush();

            $emDoctrine->clear();
            $progress->advance();
        }
        $progress->finish();
        $output->writeln("");
        $output->writeln("<info>Terminé, $compteurAjout lignes ajoutés, $countCorrespondanceMultiple supprimées.</info>");

    }
}