<?php

namespace CityFinderBundle\Security;


use Symfony\Component\Cache\Adapter\MemcachedAdapter;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class MemcachedAuthTokenUserProvider implements UserProviderInterface {

    /**
     * @var MemcachedAdapter
     */
    private  $memCachedManager;


    public function __construct($products)
    {
        $this->memCachedManager = $products;
    }

    /**
     * Loads the user for the given username.
     *
     * This method must throw UsernameNotFoundException if the user is not
     * found.
     *
     * @param string $email The username (here we use a mail)
     *
     * @return UserInterface
     *
     * @throws UsernameNotFoundException if the user is not found
     */
    public function loadUserByUsername($email)
    {
        // TODO: Implement loadUserByUsername() method.
        dump("MemcachedAuthTokenProvider loadUserByUsername");
    }

    /**
     * Refreshes the user.
     *
     * It is up to the implementation to decide if the user data should be
     * totally reloaded (e.g. from the database), or if the UserInterface
     * object can just be merged into some internal array of users / identity
     * map.
     *
     * @param UserInterface $user
     *
     * @return UserInterface
     *
     * @throws UnsupportedUserException if the user is not supported
     */
    public function refreshUser(UserInterface $user)
    {
        dump("MemcachedAuthTokenProvider refreshUser");
        // Le systéme d'authentification est stateless, on ne doit donc jamais appeler la méthode refreshUser
        throw new UnsupportedUserException();
    }

    /**
     * Whether this provider supports the given user class.
     *
     * @param string $class
     *
     * @return bool
     */
    public function supportsClass($class)
    {
        dump("MemcachedAuthTokenProvider supportsClass");
        return 'CityFinderBundle\Entity\User';
    }


    public function getMemcachedAuthToken($MemCachedAuthTokenHeader)
    {

        //récupération du token via son id
        $MemCachedAuthTokenItem = $this->memCachedManager->getItem($MemCachedAuthTokenHeader);

        //si on n'a pas de token valide : erreur
        if (!$MemCachedAuthTokenItem->isHit()) {
            throw new BadCredentialsException('Invalid authentication token');
        }

        $authToken = $MemCachedAuthTokenItem->get();


        //récupération de l'utilisateur correspondant au token (notre token ne dispose que de l'id de l'utilisateur)
        //cet utilisateur a été stocké dans memcached afin d'y accéder rapidement et d'être modifié en cas d'update
        $memcachedUserItem = $this->memCachedManager->getItem("user_".$authToken->getUserId());

        //si on n'a pas de token valide : erreur
        if (!$memcachedUserItem->isHit()) {
            throw new BadCredentialsException('Invalid authentication token');
        }

        $user = $memcachedUserItem->get();

        $authToken->setUser($user);

        return $authToken;
    }
}