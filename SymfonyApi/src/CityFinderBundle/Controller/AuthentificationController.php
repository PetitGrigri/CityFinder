<?php
namespace CityFinderBundle\Controller;

use CityFinderBundle\Entity\AuthTokens;
use CityFinderBundle\Entity\Credentials;
use CityFinderBundle\Entity\User;
use CityFinderBundle\Form\CredentialType;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Cache\Adapter\TraceableAdapter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 *
 */
class AuthentificationController extends Controller
{

    private  $cacheManager;


    public function __construct(TraceableAdapter $products)
    {
        $this->cacheManager = $products;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"user"})
     * @Rest\Post("/login")
     *
     * @param Request $request
     */
    public function postLoginAction(Request $request)
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

        $authToken = new AuthTokens();
        $authToken
            ->setCreatedAt(new \DateTime('now'))
            ->setUserId($user->getId());



        //récupération du token existant ayant pour clé le tokenId,
        $cacheToken     = $this->cacheManager->getItem($tokenId);

        //on enregistre notre token
        $cacheToken->set($authToken);
        $this->cacheManager->save($cacheToken);

        return $user;
    }




    private function invalidCredentials()
    {
        return new JsonResponse(['message' => 'Invalid credentials'], Response::HTTP_BAD_REQUEST);
    }
}