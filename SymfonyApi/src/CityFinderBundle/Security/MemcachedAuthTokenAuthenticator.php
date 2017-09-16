<?php
namespace CityFinderBundle\Security;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\Authentication\SimplePreAuthenticatorInterface;
use Symfony\Component\Security\Http\HttpUtils;

class MemcachedAuthTokenAuthenticator implements SimplePreAuthenticatorInterface, AuthenticationFailureHandlerInterface
{

    protected $httpUtils;


    public function __construct(HttpUtils $httpUtils)
    {
        $this->httpUtils        = $httpUtils;
    }

    public function authenticateToken(TokenInterface $token, UserProviderInterface $userProvider, $providerKey)
    {
        if (!$userProvider instanceof MemcachedAuthTokenUserProvider) {
            throw new \InvalidArgumentException(
                sprintf(
                    'The user provider must be an instance of MemcachedAuthTokenProvider (%s was given).',
                    get_class($userProvider)
                )
            );
        }

        //récupération du token Id
        $MemCachedAuthTokenHeader = $token->getCredentials();

        //récupération du token en memcached via son Id
        $authToken = $userProvider->getMemcachedAuthToken($MemCachedAuthTokenHeader);

        $user = $authToken->getUser();

        $pre = new PreAuthenticatedToken(
            $user,
            $MemCachedAuthTokenHeader,
            $providerKey,
            $user->getRoles()
        );

        $pre->setAuthenticated(true);

        return $pre;

    }

    public function supportsToken(TokenInterface $token, $providerKey)
    {
        return $token instanceof PreAuthenticatedToken && $token->getProviderKey() === $providerKey;
    }

    /**
     * @param Request $request
     * @param $providerKey
     * @return PreAuthenticatedToken
     */
    public function createToken(Request $request, $providerKey)
    {
        $targetUrl = '/authentication';

        // Si la requête est une création de token, aucune vérification n'est effectuée
        if ($request->getMethod() === "POST" && $this->httpUtils->checkRequestPath($request, $targetUrl)) {
            return;
        }

        //si on a pas dans le header Auth-Token : on lève une exception
        if (!$request->headers->has('X-Auth-Token')) {
            throw new BadCredentialsException('X-Auth-Token header is required');
        }
        //récupération de l'id du token
        $MemCachedAuthTokenHeader = $request->headers->get('X-Auth-Token');

        return new PreAuthenticatedToken(
            'anon.',
            $MemCachedAuthTokenHeader,
            $providerKey
        );
    }

    /**
     * This is called when an interactive authentication attempt fails. This is
     * called by authentication listeners inheriting from
     * AbstractAuthenticationListener.
     *
     * @param Request $request
     * @param AuthenticationException $exception
     *
     * @return Response The response to return, never null
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        // Si les données d'identification ne sont pas correctes, une exception est levée
        throw $exception;
    }
}