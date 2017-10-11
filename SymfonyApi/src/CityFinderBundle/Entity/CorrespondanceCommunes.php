<?php

namespace CityFinderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CorrespondanceCommunes
 *
 * @ORM\Table(name="correspondance_communes")
 * @ORM\Entity
 */
class CorrespondanceCommunes
{
    /**
     * @var string
     *
     * @ORM\Column(name="insee", type="string", length=5, nullable=true)
     */
    private $insee;

    /**
     * @var string
     *
     * @ORM\Column(name="postal", type="string", length=47, nullable=true)
     */
    private $postal;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=100, nullable=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_dept", type="string", length=40, nullable=true)
     */
    private $nomDept;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_region", type="string", length=40, nullable=true)
     */
    private $nomRegion;

    /**
     * @var string
     *
     * @ORM\Column(name="statut", type="string", length=40, nullable=true)
     */
    private $statut;

    /**
     * @var string
     *
     * @ORM\Column(name="altitude_moyenne", type="decimal", precision=6, scale=2, nullable=true)
     */
    private $altitudeMoyenne;

    /**
     * @var string
     *
     * @ORM\Column(name="superficie", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $superficie;

    /**
     * @var string
     *
     * @ORM\Column(name="Population", type="decimal", precision=6, scale=2, nullable=true)
     */
    private $population;

    /**
     * @var string
     *
     * @ORM\Column(name="geo_point_2d", type="text", length=65535, nullable=true)
     */
    private $geoPoint2d;

    /**
     * @var string
     *
     * @ORM\Column(name="geo_shape", type="text", length=65535, nullable=true)
     */
    private $geoShape;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_geofla", type="integer", nullable=true)
     */
    private $idGeofla;

    /**
     * @var integer
     *
     * @ORM\Column(name="code_commune", type="integer", nullable=true)
     */
    private $codeCommune;

    /**
     * @var integer
     *
     * @ORM\Column(name="code_canton", type="integer", nullable=true)
     */
    private $codeCanton;

    /**
     * @var integer
     *
     * @ORM\Column(name="code_arrondissement", type="integer", nullable=true)
     */
    private $codeArrondissement;

    /**
     * @var string
     *
     * @ORM\Column(name="code_dep", type="string", length=2, nullable=true)
     */
    private $codeDep;

    /**
     * @var integer
     *
     * @ORM\Column(name="code_reg", type="integer", nullable=true)
     */
    private $codeReg;

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
    public function getInsee()
    {
        return $this->insee;
    }

    /**
     * @param string $insee
     * @return CorrespondanceCommunes
     */
    public function setInsee($insee)
    {
        $this->insee = $insee;
        return $this;
    }

    /**
     * @return string
     */
    public function getPostal()
    {
        return $this->postal;
    }

    /**
     * @param string $postal
     * @return CorrespondanceCommunes
     */
    public function setPostal($postal)
    {
        $this->postal = $postal;
        return $this;
    }

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     * @return CorrespondanceCommunes
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * @return string
     */
    public function getNomDept()
    {
        return $this->nomDept;
    }

    /**
     * @param string $nomDept
     * @return CorrespondanceCommunes
     */
    public function setNomDept($nomDept)
    {
        $this->nomDept = $nomDept;
        return $this;
    }

    /**
     * @return string
     */
    public function getNomRegion()
    {
        return $this->nomRegion;
    }

    /**
     * @param string $nomRegion
     * @return CorrespondanceCommunes
     */
    public function setNomRegion($nomRegion)
    {
        $this->nomRegion = $nomRegion;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * @param string $statut
     * @return CorrespondanceCommunes
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;
        return $this;
    }

    /**
     * @return string
     */
    public function getAltitudeMoyenne()
    {
        return $this->altitudeMoyenne;
    }

    /**
     * @param string $altitudeMoyenne
     * @return CorrespondanceCommunes
     */
    public function setAltitudeMoyenne($altitudeMoyenne)
    {
        $this->altitudeMoyenne = $altitudeMoyenne;
        return $this;
    }

    /**
     * @return string
     */
    public function getSuperficie()
    {
        return $this->superficie;
    }

    /**
     * @param string $superficie
     * @return CorrespondanceCommunes
     */
    public function setSuperficie($superficie)
    {
        $this->superficie = $superficie;
        return $this;
    }

    /**
     * @return string
     */
    public function getPopulation()
    {
        return $this->population;
    }

    /**
     * @param string $population
     * @return CorrespondanceCommunes
     */
    public function setPopulation($population)
    {
        $this->population = $population;
        return $this;
    }

    /**
     * @return string
     */
    public function getGeoPoint2d()
    {
        return $this->geoPoint2d;
    }

    /**
     * @param string $geoPoint2d
     * @return CorrespondanceCommunes
     */
    public function setGeoPoint2d($geoPoint2d)
    {
        $this->geoPoint2d = $geoPoint2d;
        return $this;
    }

    /**
     * @return string
     */
    public function getGeoShape()
    {
        return $this->geoShape;
    }

    /**
     * @param string $geoShape
     * @return CorrespondanceCommunes
     */
    public function setGeoShape($geoShape)
    {
        $this->geoShape = $geoShape;
        return $this;
    }

    /**
     * @return int
     */
    public function getIdGeofla()
    {
        return $this->idGeofla;
    }

    /**
     * @param int $idGeofla
     * @return CorrespondanceCommunes
     */
    public function setIdGeofla($idGeofla)
    {
        $this->idGeofla = $idGeofla;
        return $this;
    }

    /**
     * @return int
     */
    public function getCodeCommune()
    {
        return $this->codeCommune;
    }

    /**
     * @param int $codeCommune
     * @return CorrespondanceCommunes
     */
    public function setCodeCommune($codeCommune)
    {
        $this->codeCommune = $codeCommune;
        return $this;
    }

    /**
     * @return int
     */
    public function getCodeCanton()
    {
        return $this->codeCanton;
    }

    /**
     * @param int $codeCanton
     * @return CorrespondanceCommunes
     */
    public function setCodeCanton($codeCanton)
    {
        $this->codeCanton = $codeCanton;
        return $this;
    }

    /**
     * @return int
     */
    public function getCodeArrondissement()
    {
        return $this->codeArrondissement;
    }

    /**
     * @param int $codeArrondissement
     * @return CorrespondanceCommunes
     */
    public function setCodeArrondissement($codeArrondissement)
    {
        $this->codeArrondissement = $codeArrondissement;
        return $this;
    }

    /**
     * @return string
     */
    public function getCodeDep()
    {
        return $this->codeDep;
    }

    /**
     * @param string $codeDep
     * @return CorrespondanceCommunes
     */
    public function setCodeDep($codeDep)
    {
        $this->codeDep = $codeDep;
        return $this;
    }

    /**
     * @return int
     */
    public function getCodeReg()
    {
        return $this->codeReg;
    }

    /**
     * @param int $codeReg
     * @return CorrespondanceCommunes
     */
    public function setCodeReg($codeReg)
    {
        $this->codeReg = $codeReg;
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
     * @return CorrespondanceCommunes
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
}

