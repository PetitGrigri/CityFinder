<?php

namespace CityFinderBundle\Controller;

use CityFinderBundle\Entity\DonneesCommunes;
use CityFinderBundle\Entity\LogsRecherches;
use CityFinderBundle\Form\LogsRecherchesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Route("/search")
 * Class SearchController
 * @package CityFinderBundle\Controller
 */
class SearchController extends Controller
{
    /**
     * @Route("/")
     */
    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $request->headers->get('X-Auth-Token');

        $m = new \Memcached();
        $m->addServer('localhost', 11211);
        $token1 = $m->get('BHWI5bLvG1wPwaiyIqSNHNg/vVta72LLW/0SQ9PpkSv2G7CKQbRfmjgunGYoPXys4c4=');


        if (isset($token1['userId'])) {
            $logRecherche   = new LogsRecherches();
            $logRecherche->setUtilisateur($token1['userId']);

            $formulaire     = $this->createForm(LogsRecherchesType::class, $logRecherche);

            $formulaire->submit($request->query->all(), false);

            $em->persist($logRecherche);
            $em->flush();


            $commune= $this->getDoctrine()->getRepository(DonneesCommunes::class)->findOneBy([
                "comNom"  => "PARIS",
            ]);

            return new JsonResponse([
                "ville" =>$commune->getComNom(),
                "lat"   =>$commune->getLat(),
                "long"  =>$commune->getLong(),
            ]);

        } else {
            return new JsonResponse([
                "message"   => "Error Credentials",
            ]);
        }


    }
}