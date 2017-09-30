<?php

namespace CityFinderBundle\Controller;

use CityFinderBundle\Node\Centrale;
use CityFinderBundle\Node\Commune;
use CityFinderBundle\Utils\ServicesTraits;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchTestController extends Controller
{
    use ServicesTraits;
    /**
     * @return mixed
     * @Method({"GET", "POST"})
     * @Route("/search-test/{commune}", name="web_commune_search", defaults={"commune" = "Orléans"} )
     */
    public function webCommuneSearchAction(Request $request, $commune)
    {

        $form = $this->createFormBuilder(new class { public $recherche; })
            ->add('recherche', TextType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return new RedirectResponse($this->generateUrl('web_commune_search', [
                "commune" => $form->getData()->recherche,
            ]));
        }

        $em=$this->getNeo4jEntityManager();

        /**
         * @var Commune $communeEntity
         */
        $communeEntity = $em->getRepository(Commune::class)->findOneBy([
            'name'  => $commune,
        ]);

        return $this->render('search/search.html.twig', [
            'commune'   => $communeEntity,
            'form'      => $form->createView(),
        ]);

    }
}
