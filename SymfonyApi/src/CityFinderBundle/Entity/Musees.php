<?php

namespace CityFinderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Musees
 *
 * @ORM\Table(name="musees")
 * @ORM\Entity
 */
class Musees
{
    /**
     * @var string
     *
     * @ORM\Column(name="region", type="string", length=26, nullable=true)
     */
    private $region;

    /**
     * @var string
     *
     * @ORM\Column(name="departement", type="string", length=24, nullable=true)
     */
    private $departement;

    /**
     * @var string
     *
     * @ORM\Column(name="annexe", type="string", length=46, nullable=true)
     */
    private $annexe;

    /**
     * @var string
     *
     * @ORM\Column(name="musee", type="string", length=94, nullable=true)
     */
    private $musee;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=93, nullable=true)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="cp", type="string", length=5, nullable=true)
     */
    private $cp;

    /**
     * @var string
     *
     * @ORM\Column(name="localite", type="string", length=36, nullable=true)
     */
    private $localite;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=9, nullable=true)
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="fax", type="string", length=9, nullable=true)
     */
    private $fax;

    /**
     * @var string
     *
     * @ORM\Column(name="site_internet", type="string", length=137, nullable=true)
     */
    private $siteInternet;

    /**
     * @var string
     *
     * @ORM\Column(name="fermeture_annuelle", type="string", length=248, nullable=true)
     */
    private $fermetureAnnuelle;

    /**
     * @var string
     *
     * @ORM\Column(name="periode_ouverture", type="string", length=255, nullable=true)
     */
    private $periodeOuverture;

    /**
     * @var string
     *
     * @ORM\Column(name="nocturnes", type="string", length=75, nullable=true)
     */
    private $nocturnes;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param string $region
     * @return Musees
     */
    public function setRegion($region)
    {
        $this->region = $region;
        return $this;
    }

    /**
     * @return string
     */
    public function getDepartement()
    {
        return $this->departement;
    }

    /**
     * @param string $departement
     * @return Musees
     */
    public function setDepartement($departement)
    {
        $this->departement = $departement;
        return $this;
    }

    /**
     * @return string
     */
    public function getAnnexe()
    {
        return $this->annexe;
    }

    /**
     * @param string $annexe
     * @return Musees
     */
    public function setAnnexe($annexe)
    {
        $this->annexe = $annexe;
        return $this;
    }

    /**
     * @return string
     */
    public function getMusee()
    {
        return $this->musee;
    }

    /**
     * @param string $musee
     * @return Musees
     */
    public function setMusee($musee)
    {
        $this->musee = $musee;
        return $this;
    }

    /**
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param string $adresse
     * @return Musees
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
        return $this;
    }

    /**
     * @return string
     */
    public function getCp()
    {
        return $this->cp;
    }

    /**
     * @param string $cp
     * @return Musees
     */
    public function setCp($cp)
    {
        $this->cp = $cp;
        return $this;
    }

    /**
     * @return string
     */
    public function getLocalite()
    {
        return $this->localite;
    }

    /**
     * @param string $localite
     * @return Musees
     */
    public function setLocalite($localite)
    {
        $this->localite = $localite;
        return $this;
    }

    /**
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param string $telephone
     * @return Musees
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
        return $this;
    }

    /**
     * @return string
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * @param string $fax
     * @return Musees
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
        return $this;
    }

    /**
     * @return string
     */
    public function getSiteInternet()
    {
        return $this->siteInternet;
    }

    /**
     * @param string $siteInternet
     * @return Musees
     */
    public function setSiteInternet($siteInternet)
    {
        $this->siteInternet = $siteInternet;
        return $this;
    }

    /**
     * @return string
     */
    public function getFermetureAnnuelle()
    {
        return $this->fermetureAnnuelle;
    }

    /**
     * @param string $fermetureAnnuelle
     * @return Musees
     */
    public function setFermetureAnnuelle($fermetureAnnuelle)
    {
        $this->fermetureAnnuelle = $fermetureAnnuelle;
        return $this;
    }

    /**
     * @return string
     */
    public function getPeriodeOuverture()
    {
        return $this->periodeOuverture;
    }

    /**
     * @param string $periodeOuverture
     * @return Musees
     */
    public function setPeriodeOuverture($periodeOuverture)
    {
        $this->periodeOuverture = $periodeOuverture;
        return $this;
    }

    /**
     * @return string
     */
    public function getNocturnes()
    {
        return $this->nocturnes;
    }

    /**
     * @param string $nocturnes
     * @return Musees
     */
    public function setNocturnes($nocturnes)
    {
        $this->nocturnes = $nocturnes;
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
     * @return Musees
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }


}

