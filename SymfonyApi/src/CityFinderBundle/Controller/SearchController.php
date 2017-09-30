<?php

namespace CityFinderBundle\Controller;

use CityFinderBundle\Entity\DonneesCommunes;
use CityFinderBundle\Node\Person;
use FOS\RestBundle\Controller\Annotations\Route;
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
        $term = '(?i).*'.'Matrix'.'.*';
        $query = 'MATCH (m:Movie) WHERE m.title =~ {term} RETURN m';
        $result = $this->getNeo4jClient()->run($query, ['term' => $term]);

        $em=$this->getNeo4jEntityManager();
        //echo get_class($em);



        $personnes = $em->getRepository(Person::class)->findAll();



        //test de persistance
        /*
        $fabien = new Person();
        $fabien->setName("Fabien");
        $em->persist($fabien);
        $em->flush();
        */

        //recherche de toute les personnes

        /*
        dump($personnes);

        foreach ($personnes as $person) {
            echo sprintf("- %s\n", $person->getName());
        }
        */

        $personnes = $em->getRepository(Person::class)->findBy([
            'name'  => 'Fabien'
        ]);

        //mise à jour
        /*
        $fabien = $personnes[0];
        $fabien->setBorn(1983);
        $em->flush($fabien);
        */
        foreach ($personnes as $person) {
            echo sprintf("- %s\n", $person->getName());
        }
        dump($personnes);
        //utilisation procédurale
        /*
        $movies = [];

        foreach ($result->records() as $record) {
            $movieNode = $record->get('m');

            $movie = $movieNode->values();
            //$movie['url'] = $this->generateUrl('movies_show', ['title' => $movieNode->get('title')]);

            $movies[] = $movie;

            return new JsonResponse($movies);
        }*/

        return new JsonResponse($personnes);
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