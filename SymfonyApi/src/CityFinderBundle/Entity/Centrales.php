<?php

namespace CityFinderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Centrales
 *
 * @ORM\Table(name="centrales")
 * @ORM\Entity
 */
class Centrales
{
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=11, nullable=true)
     */
    private $nom;

    /**
     * @var integer
     *
     * @ORM\Column(name="nombre_reacteur", type="integer", nullable=true)
     */
    private $nombreReacteur;

    /**
     * @var string
     *
     * @ORM\Column(name="commune", type="string", length=33, nullable=true)
     */
    private $commune;

    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="decimal", precision=18, scale=16, nullable=true)
     */
    private $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="decimal", precision=18, scale=16, nullable=true)
     */
    private $longitude;

    /**
     * @var string
     *
     * @ORM\Column(name="departement", type="string", length=15, nullable=true)
     */
    private $departement;

    /**
     * @var string
     *
     * @ORM\Column(name="rang", type="string", length=3, nullable=true)
     */
    private $rang;

    /**
     * @var string
     *
     * @ORM\Column(name="Palier", type="string", length=5, nullable=true)
     */
    private $palier;

    /**
     * @var integer
     *
     * @ORM\Column(name="puissance_thermique", type="integer", nullable=true)
     */
    private $puissanceThermique;

    /**
     * @var integer
     *
     * @ORM\Column(name="puissance_brute", type="integer", nullable=true)
     */
    private $puissanceBrute;

    /**
     * @var integer
     *
     * @ORM\Column(name="puissance_nette", type="integer", nullable=true)
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
     * @ORM\Column(name="mise_en_service", type="integer", nullable=true)
     */
    private $miseEnService;

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
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     * @return Centrales
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * @return int
     */
    public function getNombreReacteur()
    {
        return $this->nombreReacteur;
    }

    /**
     * @param int $nombreReacteur
     * @return Centrales
     */
    public function setNombreReacteur($nombreReacteur)
    {
        $this->nombreReacteur = $nombreReacteur;
        return $this;
    }

    /**
     * @return string
     */
    public function getCommune()
    {
        return $this->commune;
    }

    /**
     * @param string $commune
     * @return Centrales
     */
    public function setCommune($commune)
    {
        $this->commune = $commune;
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
     * @return Centrales
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
     * @return Centrales
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
     * @return Centrales
     */
    public function setDepartement($departement)
    {
        $this->departement = $departement;
        return $this;
    }

    /**
     * @return string
     */
    public function getRang()
    {
        return $this->rang;
    }

    /**
     * @param string $rang
     * @return Centrales
     */
    public function setRang($rang)
    {
        $this->rang = $rang;
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
     * @return Centrales
     */
    public function setPalier($palier)
    {
        $this->palier = $palier;
        return $this;
    }

    /**
     * @return int
     */
    public function getPuissanceThermique()
    {
        return $this->puissanceThermique;
    }

    /**
     * @param int $puissanceThermique
     * @return Centrales
     */
    public function setPuissanceThermique($puissanceThermique)
    {
        $this->puissanceThermique = $puissanceThermique;
        return $this;
    }

    /**
     * @return int
     */
    public function getPuissanceBrute()
    {
        return $this->puissanceBrute;
    }

    /**
     * @param int $puissanceBrute
     * @return Centrales
     */
    public function setPuissanceBrute($puissanceBrute)
    {
        $this->puissanceBrute = $puissanceBrute;
        return $this;
    }

    /**
     * @return int
     */
    public function getPuissanceNette()
    {
        return $this->puissanceNette;
    }

    /**
     * @param int $puissanceNette
     * @return Centrales
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
     * @return Centrales
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
     * @return Centrales
     */
    public function setRaccordementReseau($raccordementReseau)
    {
        $this->raccordementReseau = $raccordementReseau;
        return $this;
    }

    /**
     * @return int
     */
    public function getMiseEnService()
    {
        return $this->miseEnService;
    }

    /**
     * @param int $miseEnService
     * @return Centrales
     */
    public function setMiseEnService($miseEnService)
    {
        $this->miseEnService = $miseEnService;
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
     * @return Centrales
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }


}

