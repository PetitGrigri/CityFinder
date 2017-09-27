<?php

namespace CityFinderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CentralesNucleaires
 *
 * @ORM\Table(name="centrales_nucleaires")
 * @ORM\Entity
 */
class CentralesNucleaires
{
    /**
     * @var string
     *
     * @ORM\Column(name="nom_reacteur", type="string", length=16, nullable=true)
     */
    private $nomReacteur;

    /**
     * @var string
     *
     * @ORM\Column(name="centrale_nucleaire", type="string", length=11, nullable=true)
     */
    private $centraleNucleaire;

    /**
     * @var string
     *
     * @ORM\Column(name="localite", type="string", length=33, nullable=true)
     */
    private $localite;

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
     * @var string
     *
     * @ORM\Column(name="departement", type="string", length=15, nullable=true)
     */
    private $departement;

    /**
     * @var integer
     *
     * @ORM\Column(name="rg", type="integer", nullable=true)
     */
    private $rg;

    /**
     * @var string
     *
     * @ORM\Column(name="palier", type="string", length=3, nullable=true)
     */
    private $palier;

    /**
     * @var string
     *
     * @ORM\Column(name="puissance_thermique", type="string", length=5, nullable=true)
     */
    private $puissanceThermique;

    /**
     * @var string
     *
     * @ORM\Column(name="puisance_brute", type="string", length=5, nullable=true)
     */
    private $puisanceBrute;

    /**
     * @var string
     *
     * @ORM\Column(name="puissance_nette", type="string", length=5, nullable=true)
     */
    private $puissanceNette;

    /**
     * @var integer
     *
     * @ORM\Column(name="debut_construction", type="integer", nullable=true)
     */
    private $debutConstruction;

    /**
     * @var integer
     *
     * @ORM\Column(name="raccordement_reseau", type="integer", nullable=true)
     */
    private $raccordementReseau;

    /**
     * @var integer
     *
     * @ORM\Column(name="mise_service", type="integer", nullable=true)
     */
    private $miseService;

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
    public function getNomReacteur()
    {
        return $this->nomReacteur;
    }

    /**
     * @param string $nomReacteur
     * @return CentralesNucleaires
     */
    public function setNomReacteur($nomReacteur)
    {
        $this->nomReacteur = $nomReacteur;
        return $this;
    }

    /**
     * @return string
     */
    public function getCentraleNucleaire()
    {
        return $this->centraleNucleaire;
    }

    /**
     * @param string $centraleNucleaire
     * @return CentralesNucleaires
     */
    public function setCentraleNucleaire($centraleNucleaire)
    {
        $this->centraleNucleaire = $centraleNucleaire;
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
     * @return CentralesNucleaires
     */
    public function setLocalite($localite)
    {
        $this->localite = $localite;
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
     * @return CentralesNucleaires
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
     * @return CentralesNucleaires
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
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
     * @return CentralesNucleaires
     */
    public function setDepartement($departement)
    {
        $this->departement = $departement;
        return $this;
    }

    /**
     * @return int
     */
    public function getRg()
    {
        return $this->rg;
    }

    /**
     * @param int $rg
     * @return CentralesNucleaires
     */
    public function setRg($rg)
    {
        $this->rg = $rg;
        return $this;
    }

    /**
     * @return string
     */
    public function getPalier()
    {
        return $this->palier;
    }

    /**
     * @param string $palier
     * @return CentralesNucleaires
     */
    public function setPalier($palier)
    {
        $this->palier = $palier;
        return $this;
    }

    /**
     * @return string
     */
    public function getPuissanceThermique()
    {
        return $this->puissanceThermique;
    }

    /**
     * @param string $puissanceThermique
     * @return CentralesNucleaires
     */
    public function setPuissanceThermique($puissanceThermique)
    {
        $this->puissanceThermique = $puissanceThermique;
        return $this;
    }

    /**
     * @return string
     */
    public function getPuisanceBrute()
    {
        return $this->puisanceBrute;
    }

    /**
     * @param string $puisanceBrute
     * @return CentralesNucleaires
     */
    public function setPuisanceBrute($puisanceBrute)
    {
        $this->puisanceBrute = $puisanceBrute;
        return $this;
    }

    /**
     * @return string
     */
    public function getPuissanceNette()
    {
        return $this->puissanceNette;
    }

    /**
     * @param string $puissanceNette
     * @return CentralesNucleaires
     */
    public function setPuissanceNette($puissanceNette)
    {
        $this->puissanceNette = $puissanceNette;
        return $this;
    }

    /**
     * @return int
     */
    public function getDebutConstruction()
    {
        return $this->debutConstruction;
    }

    /**
     * @param int $debutConstruction
     * @return CentralesNucleaires
     */
    public function setDebutConstruction($debutConstruction)
    {
        $this->debutConstruction = $debutConstruction;
        return $this;
    }

    /**
     * @return int
     */
    public function getRaccordementReseau()
    {
        return $this->raccordementReseau;
    }

    /**
     * @param int $raccordementReseau
     * @return CentralesNucleaires
     */
    public function setRaccordementReseau($raccordementReseau)
    {
        $this->raccordementReseau = $raccordementReseau;
        return $this;
    }

    /**
     * @return int
     */
    public function getMiseService()
    {
        return $this->miseService;
    }

    /**
     * @param int $miseService
     * @return CentralesNucleaires
     */
    public function setMiseService($miseService)
    {
        $this->miseService = $miseService;
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
     * @return CentralesNucleaires
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }



}

