<?php

namespace CityFinderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LogsRecherches
 *
 * @ORM\Table(name="logs_recherches")
 * @ORM\Entity
 */
class LogsRecherches
{
    /**
     * @var integer
     *
     * @ORM\Column(name="utilisateur", type="integer", nullable=false)
     */
    private $utilisateur;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_recherche", type="datetime", nullable=false)
     */
    private $dateRecherche;

    /**
     * @var string
     *
     * @ORM\Column(name="recherche", type="text", length=65535, nullable=false)
     */
    private $recherche;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @return int
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }

    /**
     * @param int $utilisateur
     * @return LogsRecherches
     */
    public function setUtilisateur($utilisateur)
    {
        $this->utilisateur = $utilisateur;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateRecherche()
    {
        return $this->dateRecherche;
    }

    /**
     * @param \DateTime $dateRecherche
     * @return LogsRecherches
     */
    public function setDateRecherche($dateRecherche)
    {
        $this->dateRecherche = $dateRecherche;
        return $this;
    }

    /**
     * @return string
     */
    public function getRecherche()
    {
        return $this->recherche;
    }

    /**
     * @param string $recherche
     * @return LogsRecherches
     */
    public function setRecherche($recherche)
    {
        $this->recherche = $recherche;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return LogsRecherches
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }


}

