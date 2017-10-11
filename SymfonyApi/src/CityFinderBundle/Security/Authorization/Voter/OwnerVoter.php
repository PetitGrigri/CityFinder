<?php
namespace CityFinderBundle\Security\Authorization\Voter;

use CityFinderBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class OwnerVoter extends Voter {

    const OWNER = "owner";

    /**
     * Determines if the attribute and subject are supported by this voter.
     *
     * @param string $attribute An attribute
     * @param mixed $subject The subject to secure, e.g. an object the user wants to access or any other PHP type
     *
     * @return bool True if the attribute and subject are supported, false otherwise
     */
    protected function supports($attribute, $subject)
    {
        if ($subject instanceof User)
            return true;
        else
            return false;
    }

    /**
     * Perform a single access check operation on a given attribute, subject and token.
     * It is safe to assume that $attribute and $subject already passed the "supports()" method check.
     *
     * @param string $attribute
     * @param mixed $subject
     * @param TokenInterface $token
     *
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        switch ($attribute) {
            //vérification du propriétaire
            case (self::OWNER) :
                if ($subject instanceof User)  {
                    return (($token->getUser() !== null) && ($token->getUser()->getId() === $subject->getId()));
                } else if (($token->getUser() !== null) && ($token->getUser()->getId() === $subject->getUser()->getId())){
                    return true;
                }
                break;
        }
        return false;
    }
}
