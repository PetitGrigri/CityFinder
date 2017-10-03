<?php

namespace CityFinderBundle\Controller;

use CityFinderBundle\Form\SearchType;
use CityFinderBundle\Node\Commune;
use CityFinderBundle\Utils\ServicesCommandTraits;
use CityFinderBundle\Utils\ServicesControllerTraits;
use FOS\RestBundle\Controller\Annotations\Route;
use GraphAware\Bolt\Protocol\V1\Response;
use GraphAware\Neo4j\OGM\EntityManager;
use GraphAware\Neo4j\OGM\Query;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            $emNeo4j    = $this->getNeo4jEntityManager();

            $queryRaw   = $this->queryBuilder($form->getData());

            //dump($queryRaw);

            $query = $emNeo4j->createQuery($queryRaw);
            $query->addEntityMapping('c', Commune::class);



            $result =  $query->execute();
            $retour = [];
            foreach ($result as $commune) {
                $retour[]=$commune["communes"]->asArray();
            }


            return $retour;
        }

    }

    public function queryBuilder($recherche)
    {
        $query = '';
        $queryBegin = 'MATCH (c:Commune) WHERE true ';
        $queryEnd = 'RETURN c AS communes LIMIT 10 ';

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




        return $queryBegin.$query.$queryEnd;

    }

}