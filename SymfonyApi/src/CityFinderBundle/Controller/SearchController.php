<?php

namespace CityFinderBundle\Controller;

use CityFinderBundle\Node\Commune;
use FOS\RestBundle\Controller\Annotations\Route;
use GraphAware\Bolt\Protocol\V1\Response;
use GraphAware\Neo4j\OGM\EntityManager;
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


    /**
     * @Rest\Get()
     * @Rest\View()
     *
     * @param Request $request
     * @return mixed
     */
    public function neo4jSearchAction(Request $request)
    {
        //$searchTerm = $request->query->get('q');
        //$term = '(?i).*'.'Matrix'.'.*';
        //$query = 'MATCH (m:Movie) WHERE m.title =~ {term} RETURN m';
        $result = $this->getNeo4jClient()->run($query, ['term' => $term]);

        $em=$this->getNeo4jEntityManager();
        //echo get_class($em);

        $personnes = $em->getRepository(Commune::class)->findAll();

        $jouy = $em->getRepository(Commune::class)->findOneBy([
            'name'  => 'Jouy-le-Potier'
        ]);

        dump($jouy);

        return new Response('test');
        //return new JsonResponse($personnes);
    }

    /**
     * @return \GraphAware\Neo4j\Client\Client
     */
    private function getNeo4jClient()
    {
        return $this->get('neo4j.client');
    }

    /**
     * @return EntityManager object
     */
    private function getNeo4jEntityManager() {
        return $this->get('neo4j.entity_manager.default');
    }
}