<?php

namespace CityFinderBundle\Controller;

use CityFinderBundle\Form\SearchType;
use CityFinderBundle\Node\Commune;
use CityFinderBundle\Utils\ServicesControllerTraits;
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

    use ServicesControllerTraits;

    /**
     * @Rest\Post()
     * @Rest\View()
     * @param Request $request
     * @return mixed
     */
    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        //récupération de l'utilisateur lié au token (pour enregistrer sa requête)
        $user   = $this->get('security.token_storage')->getToken()->getUser();

        //récupération des paramètres du formulaire
        $form   = $this->createForm(SearchType::class, []);

        //remplissage du formulaire via la request
        $form->submit($request->request->all());

        //si le formulaire est invalide, on le retourne
        if (!$form->isValid()) {
            return $form;
        } else {
            //création de la requête à partir de notre recherche
            $queryRaw   = $this->queryBuilder($form->getData());

            //exécution de notre requête
            $result = $this->getNeo4jClient()->run($queryRaw, []);

            $communes = [];

            foreach ($result->records() as $record) {
                //récupération du "noeud" commune et de son id
                $communeNode    = $record->get('c');

                //récupération de ses données et de son id
                $commune        = $communeNode->values();
                $commune['id']  = $communeNode->identity();

                //ajout de la commune à notre array de commune
                $communes[] = $commune;
            }

            return $communes;

        }
    }

    /**
     *
     * Permet d'obtenir des informations sur une ville précise
     *
     * @Rest\Get("/detail/{id}")
     * @Rest\View(serializerGroups={"commune"})
     * @param Request $request
     * @return mixed
     */
    public function detailAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        //récupération de l'utilisateur lié au token (pour enregistrer sa requête)
        $user   = $this->get('security.token_storage')->getToken()->getUser();

        //récupération des paramètres du formulaire
        $form   = $this->createForm(SearchType::class, []);

        $emNeo4j    = $this->getNeo4jEntityManager();

        $commune = $emNeo4j->getRepository(Commune::class)->find($id);

        return $commune;

    }


    /**
     * @param $recherche
     * @return string
     */
    public function queryBuilder($recherche)
    {
        $query = '';
        $queryBegin = 'MATCH (c:Commune) WHERE true ';
        $queryEnd = 'RETURN c LIMIT 10 ';

        //gestion des centrales
        if (isset($recherche['centrales'])) {
            switch ($recherche['centrales']) {
                case SearchType::CENTRALES_MORE_THAN_20:
                    $query.='AND NOT (c)-[:NEAR_20KM_FROM]->(:Centrale) ';
                    break;
                case SearchType::CENTRALES_MORE_THAN_30:
                    $query.='AND NOT (c)-[:NEAR_30KM_FROM]->(:Centrale) ';
                    break;
                case SearchType::CENTRALES_MORE_THAN_80:
                    $query.='AND NOT (c)-[:NEAR_80KM_FROM]->(:Centrale) ';
                    break;
            }
        }

        //gestion des musees
        if ((isset($recherche['musees'])) && ($recherche['musees'] == SearchType::MUSEES_NEEDED)) {
            $query .= 'AND (c)<-[:LOCATED_IN]-(:Musee) ';
        }

        //gestion des musees
        if ((isset($recherche['hotels'])) && ($recherche['hotels'] == SearchType::HOTELS_NEEDED)) {
            $query .= 'AND (c)<-[:LOCATED_IN]-(:Hotel) ';
        }

        //gestion des musees
        if (isset($recherche['postes'])) {
            switch ($recherche['postes']) {
                case SearchType::POSTES_NEEDED:
                    $query .= 'AND (c)<-[:LOCATED_IN]-(:AgencePostale) ';
                    break;
            }
        }

        //gestion des département
        if (isset($recherche['code_departement'])) {
            $query .= 'AND c.codeDepartement = "'.$recherche['code_departement'].'" ';
        }

        //gestion des régions
        if (isset($recherche['code_region'])) {
            $query .= 'AND c.codeRegion = '.$recherche['code_region'].' ';
        }

        return $queryBegin.$query.$queryEnd;

    }

}