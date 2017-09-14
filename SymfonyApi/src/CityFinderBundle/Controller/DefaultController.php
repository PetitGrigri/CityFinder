<?php

namespace CityFinderBundle\Controller;

use CityFinderBundle\Entity\AuthTokens;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Cache\Adapter\MemcachedAdapter;
use Symfony\Component\Cache\Simple\MemcachedCache;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


/**
 * @Route("/authentification")
 * Class DefaultController
 * @package CityFinderBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function withDoctrineAction()
    {
        $em = $this->getDoctrine()->getManager();

        /**
         * @var AuthTokens $token
         */
        $token = $em->getRepository(AuthTokens::class)->find(1);

        return new JsonResponse(([
            "id"        => $token->getId(),
            "userId"    => $token->getUserId(),
            "createAt"  => $token->getCreatedAt(),
            "value"     => $token->getValue()
        ]));
    }


    /**
     * @Route("/memcache")
     */
    public function memCacheAction()
    {
        $cacheTokenItem = $this->get('app.cache.products')->getItem('BHWI5bLvG1wPwaiyIqSNHNgvVta72LLW0SQ9PpkSv2G7CKQbRfmjgunGYoPXys4c4=');

        if (!$cacheTokenItem->isHit()) {
            throw new NotFoundHttpException("Invalid or expired Token");
        }

        $token = $cacheTokenItem->get();

        return new JsonResponse([
            "id"        => $token->getId(),
            "value"     => $token->getValue(),
            "userId"    => $token->getUserId(),

        ]);
    }

    /**
     *
     * Les actions de cette route seront réalisées lors de la connexion (pour un seul utilisateur), afin de générer un token
     * voir https://symfony.com/blog/new-in-symfony-3-3-memcached-cache-adapter
     * @Route("/memcache/initialisation")
     */
    public function initialisation()
    {
        $em             = $this->getDoctrine()->getManager();   //entity manager
        $cacheManager   = $this->get('app.cache.products');     //cache manager

        //récupération de la liste de tout les tokens
        $tokens = $em->getRepository(AuthTokens::class)->findAll();

        foreach ($tokens as $token) {
            //le générateur de token de symfony met des caractères spéciaux dans les tokens (on les supprimes ici)
            $tempoTokenId   = str_replace(["{","}","(",")","/","\\","@",":"],"",$token->getValue());

            //récupération du token existant ayant pour clé le tokenId,
            $cacheToken     = $cacheManager->getItem($tempoTokenId);

            //on enregistre notre token
            $cacheToken->set($token);
            $cacheManager->save($cacheToken);
        }

        return $this->render('CityFinderBundle:Default:index.html.twig');
    }
}