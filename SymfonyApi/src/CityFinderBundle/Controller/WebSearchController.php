<?php

namespace CityFinderBundle\Controller;

use CityFinderBundle\Entity\Communes;
use CityFinderBundle\Node\Commune;
use CityFinderBundle\Utils\ServicesTraits;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SearchTestController
 * @Route("/search-commune")
 * @package CityFinderBundle\Controller
 */
class WebSearchController extends Controller
{
    use ServicesTraits;

    /**
     * @return mixed
     * @Method({"GET", "POST"})
     * @Route("",
     *          name="web_commune_search_index",
     *          defaults={"commune" = null, "departement" = null} )
     */
    public function indexSearchCommuneWeb()
    {
        return $this->render('search/index.html.twig');
    }
    /**
     * @return Response
     * @Method({"GET"})
     * @Route("/alternatives/{commune}", name="web_commune_proposition")
     */
    public function webCommuneSearchPropositionsAction($commune)
    {
        $form = $this->generateSearchForm();

        //récupération de l'entity manager de neo4j
        $communesRepository = $this->getDoctrine()->getRepository(Communes::class);

        dump($communesRepository);
        return $this->render('search/propositions.html.twig', [
            'commune'           => $commune,
            'propositions'      => $communesRepository->findCommuneLike($commune),
            'form'              => $form->createView(),
        ]);

    }

    /**
     * @return mixed
     * @Method({"GET", "POST"})
     * @Route("/details/{commune}/{departement}",
     *          name="web_commune_search",
     *          defaults={"commune" = null, "departement" = null} )
     */
    public function webCommuneSearchAction(Request $request, $commune, $departement=null)
    {
        //création du formulaire
        $form = $this->generateSearchForm();

        //réception de la requête
        $form->handleRequest($request);

        //si la requête du formulaire est correcte : on redirige
        if ($form->isSubmitted() && $form->isValid()) {
            return new RedirectResponse($this->generateUrl('web_commune_search', [
                "commune" => $form->getData()->recherche,
            ]));
        }

        //récupération de l'entity manager de neo4j
        $em=$this->getNeo4jEntityManager();

        //la recherche
        $search = [ 'name'  => $commune ];

        //configuration de la recherche (certains communes existe plusieurs fois dans ce cas, on utilise aussi le code département)
        if ($departement != null)
            $search['codeDepartement'] = $departement;

        $communeEntity = $em->getRepository(Commune::class)->findBy($search);

        if (count($communeEntity) != 1) {
            return new RedirectResponse($this->generateUrl('web_commune_proposition', [
                "commune" => $commune,
            ]));
        }

        return $this->render('search/search.html.twig', [
            'commune'   => $communeEntity[0],

        ]);

    }



    public function getNavigationAction() {
        return $this->render('search/navbar.html.twig', [
            'form'      => $this->generateSearchForm()->createView(),
        ]);
    }

    private function generateSearchForm() {
        return $this->createFormBuilder(new class { public $recherche; })
            ->add('recherche', TextType::class)
            ->getForm();
    }
}
