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
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


/**
 * @Route("/search")
 * Class SearchController
 * @package CityFinderBundle\Controller
 */
class SearchController extends Controller
{

    use ServicesControllerTraits;
    use SearchControllerTraits;

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
                $commune            = $communeNode->values();
                $commune['id']      = $communeNode->identity();
                $commune['href']    = $this->generateUrl('detail_commune',  ['id'=>$commune['id']], UrlGeneratorInterface::ABSOLUTE_URL);

                //ajout de la commune à notre array de commune
                $communes[] = $commune;
            }

            return $communes;
        }
        return $form;
    }

    /**
     *
     * Permet d'obtenir des informations sur une ville précise
     *
     * @Rest\Get("/detail/{id}", name="detail_commune")
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
     *
     * Permet d'obtenir l'url wikipedia
     *
     * @Rest\Get("/wikipedia/{commune}", name="wikipedia")
     * @Rest\View()
     * @return mixed
     */
    public function wikipediaAction($commune)
    {
        $image = $this->getWikipediaImage($commune);

        if ($image == null) {
            throw new NotFoundHttpException("Aucune image trouvée");
        }
        return ['url_wikipedia'=>$image];
    }
}