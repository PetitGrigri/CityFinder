<?php

namespace CityFinderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AgencesPostales
 *
 * @ORM\Table(name="agences_postales")
 * @ORM\Entity
 */
class AgencesPostales
{
    /**
     * @var string
     *
     * @ORM\Column(name="identifiant_du_site", type="string", length=6, nullable=true)
     */
    private $identifiantDuSite;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle_site", type="string", length=38, nullable=true)
     */
    private $libelleSite;

    /**
     * @var string
     *
     * @ORM\Column(name="caracteristique_site", type="string", length=29, nullable=true)
     */
    private $caracteristiqueSite;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=38, nullable=true)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="complement_adresse", type="string", length=38, nullable=true)
     */
    private $complementAdresse;

    /**
     * @var string
     *
     * @ORM\Column(name="lieu_dit", type="string", length=37, nullable=true)
     */
    private $lieuDit;

    /**
     * @var integer
     *
     * @ORM\Column(name="code_postal", type="integer", nullable=true)
     */
    private $codePostal;

    /**
     * @var string
     *
     * @ORM\Column(name="localite", type="string", length=32, nullable=true)
     */
    private $localite;

    /**
     * @var string
     *
     * @ORM\Column(name="code_INSEE", type="string", length=5, nullable=true)
     */
    private $codeInsee;

    /**
     * @var string
     *
     * @ORM\Column(name="pays", type="string", length=6, nullable=true)
     */
    private $pays;

    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="decimal", precision=8, scale=6, nullable=true)
     */
    private $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="decimal", precision=8, scale=6, nullable=true)
     */
    private $longitude;

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
    public function getIdentifiantDuSite()
    {
        return $this->identifiantDuSite;
    }

    /**
     * @param string $identifiantDuSite
     * @return AgencesPostales
     */
    public function setIdentifiantDuSite($identifiantDuSite)
    {
        $this->identifiantDuSite = $identifiantDuSite;
        return $this;
    }

    /**
     * @return string
     */
    public function getLibelleSite()
    {
        return $this->libelleSite;
    }

    /**
     * @param string $libelleSite
     * @return AgencesPostales
     */
    public function setLibelleSite($libelleSite)
    {
        $this->libelleSite = $libelleSite;
        return $this;
    }

    /**
     * @return string
     */
    public function getCaracteristiqueSite()
    {
        return $this->caracteristiqueSite;
    }

    /**
     * @param string $caracteristiqueSite
     * @return AgencesPostales
     */
    public function setCaracteristiqueSite($caracteristiqueSite)
    {
        $this->caracteristiqueSite = $caracteristiqueSite;
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
     * @return AgencesPostales
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
        return $this;
    }

    /**
     * @return string
     */
    public function getComplementAdresse()
    {
        return $this->complementAdresse;
    }

    /**
     * @param string $complementAdresse
     * @return AgencesPostales
     */
    public function setComplementAdresse($complementAdresse)
    {
        $this->complementAdresse = $complementAdresse;
        return $this;
    }

    /**
     * @return string
     */
    public function getLieuDit()
    {
        return $this->lieuDit;
    }

    /**
     * @param string $lieuDit
     * @return AgencesPostales
     */
    public function setLieuDit($lieuDit)
    {
        $this->lieuDit = $lieuDit;
        return $this;
    }

    /**
     * @return int
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * @param int $codePostal
     * @return AgencesPostales
     */
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;
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
     * @return AgencesPostales
     */
    public function setLocalite($localite)
    {
        $this->localite = $localite;
        return $this;
    }

    /**
     * @return string
     */
    public function getCodeInsee()
    {
        return $this->codeInsee;
    }

    /**
     * @param string $codeInsee
     * @return AgencesPostales
     */
    public function setCodeInsee($codeInsee)
    {
        $this->codeInsee = $codeInsee;
        return $this;
    }

    /**
     * @return string
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * @param string $pays
     * @return AgencesPostales
     */
    public function setPays($pays)
    {
        $this->pays = $pays;
        return $this;
    }

    /**
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param string $latitude
     * @return AgencesPostales
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param string $longitude
     * @return AgencesPostales
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
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
     * @return AgencesPostales
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
}

