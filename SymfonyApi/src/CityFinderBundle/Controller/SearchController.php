<?php

namespace CityFinderBundle\Controller;

use CityFinderBundle\Entity\DonneesCommunes;
use FOS\RestBundle\Controller\Annotations\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
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
     * @Rest\Post()
     * @Rest\View()
     *
     * @param Request $request
     * @return mixed
     */
    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        //récupération de l'utilisateur lié au token (pour enregistrer sa requête)
        $user = $this->get('security.token_storage')->getToken()->getUser();


        //$logRecherche   = new LogsRecherches(); //todo implémenter la recherche


        $commune= $em->getRepository(DonneesCommunes::class)->findOneBy([
            "comNom"  => "PARIS",
        ]);

        return new JsonResponse([
            "ville" =>$commune->getComNom(),
            "lat"   =>$commune->getLat(),
            "long"  =>$commune->getLong(),
        ]);


    }
}