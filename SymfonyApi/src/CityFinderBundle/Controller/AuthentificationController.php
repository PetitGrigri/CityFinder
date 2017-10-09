<?php
namespace CityFinderBundle\Controller;

use CityFinderBundle\Entity\Credentials;
use CityFinderBundle\Entity\User;
use CityFinderBundle\Form\CredentialType;
use CityFinderBundle\MemCached\AuthTokens;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Cache\Adapter\MemcachedAdapter;
use Symfony\Component\Cache\Adapter\TraceableAdapter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/authentication")
 *
 */
class AuthentificationController extends Controller
{
    /**
     * @var MemcachedAdapter
     */
    private  $memCachedManager;


    public function __construct($products)
    {
        $this->memCachedManager = $products;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"auth-token"})
     * @Rest\Post()
     *
     * @param Request $request
     * @return mixed
     */
    public function postCreateTokenAction(Request $request)
    {
        //Création du formulaire qui va nous permettre de vérifier les données de l'utilisateur
        $credentials    = new Credentials();
        $form           = $this->createForm(CredentialType::class, $credentials);

        //remplissage du formulaire via la request
        $form->submit($request->request->all());

        //si le formulaire est invalide, on le retourne
        if (!$form->isValid()) {
            return $form;
        }

        //récupération de l'utilisateur via doctrine
        $entityManager = $this->getDoctrine();
        $user = $entityManager->getRepository(User::class)->findOneBy([
            "email" =>  $credentials->getEmail(),

        ]);

        // Si 'l'utilisateur n'existe pas on retourne un message d'erreur
        if (!$user) {
            return $this->invalidCredentials();
        }

        //récupération du service d'encodate des mots de passes et comparaison du mot de passe
        $isPasswordValid = $this->get('security.password_encoder')->isPasswordValid($user, $credentials->getPassword());

        // Si le mot de passe n'est pas correct, on retourne un message d'erreur
        if (!$isPasswordValid) {
            return $this->invalidCredentials();
        }

        //création de l'id du token. les caractère pouvant géner memecached (cacheManager) sont supprimés du token Id
        $tokenId = str_replace(["{","}","(",")","/","\\","@",":"],"", base64_encode(random_bytes(50)));

        //Création du token
        $authToken = new AuthTokens();
        $authToken
            ->setCreatedAt(new \DateTime('now'))
            ->setUserId($user->getId())
            ->setValue($tokenId);


        //récupération (ou création) d'un CacheItem pour notre token et notre utilisateur
        // si mise à jour de l'utilisateur, on pourra actualiser ainsi l'utilisateur)
        $memCachedToken     = $this->memCachedManager->getItem($tokenId);
        $memCachedUser      = $this->memCachedManager->getItem("user_".$user->getId());

        //on enregistre notre token
        $memCachedToken->set($authToken);
        $this->memCachedManager->save($memCachedToken);

        //on enregistre notre utilisateur
        $memCachedUser->set($user);
        $this->memCachedManager->save($memCachedUser);

        return $authToken;
    }

    /**
     * Permet de d'afficher des informations sur l'utilisateur connecté
     *
     * @Rest\View(serializerGroups={"auth-token"})
     * @Rest\Get()
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getLoginInfoAction(Request $request)
    {
        //récupération de l'utilisateur lié au token
        $user = $this->get('security.token_storage')->getToken()->getUser();

        return $user;
    }

    private function invalidCredentials()
    {
        return new JsonResponse(['message' => 'Invalid credentials'], Response::HTTP_BAD_REQUEST);
    }
}