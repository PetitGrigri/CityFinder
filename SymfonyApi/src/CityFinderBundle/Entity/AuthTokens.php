<?php

namespace CityFinderBundle\Entity;

class AuthTokens
{
    /**
     * @var integer
     *
     */
    private $userId;

    /**
     * @var User
     */
    private $user;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var String
     */
    private $value;



    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     * @return AuthTokens
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return AuthTokens
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return String
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param String $value
     * @return AuthTokens
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return AuthTokens
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }


}

