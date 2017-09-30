<?php

namespace CityFinderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Communes
 *
 * @ORM\Table(name="communes")
 * @ORM\Entity
 */
class Communes
{
    /**
     * @var varcharstring
     *
     * @ORM\Column(name="insee", type="string", length=5, nullable=true)
     */
    private $insee;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=100, nullable=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="wikipedia", type="string", length=100, nullable=true)
     */
    private $wikipedia;

    /**
     * @var integer
     *
     * @ORM\Column(name="surf_m2", type="integer", nullable=true)
     */
    private $surfM2;

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
     * @ORM\Column(name="statut", type="string", length=40, nullable=true)
     */
    private $statut;

    /**
     * @var integer
     *
     * @ORM\Column(name="x_chf_lieu", type="integer", nullable=true)
     */
    private $xChfLieu;

    /**
     * @var integer
     *
     * @ORM\Column(name="y_chf_lieu", type="integer", nullable=true)
     */
    private $yChfLieu;

    /**
     * @var integer
     *
     * @ORM\Column(name="z_moyen", type="integer", nullable=true)
     */
    private $zMoyen;

    /**
     * @var string
     *
     * @ORM\Column(name="population", type="decimal", precision=6, scale=2, nullable=true)
     */
    private $population;

    /**
     * @var integer
     *
     * @ORM\Column(name="code_cant", type="integer", nullable=true)
     */
    private $codeCant;

    /**
     * @var integer
     *
     * @ORM\Column(name="code_arr", type="integer", nullable=true)
     */
    private $codeArr;

    /**
     * @var string
     *
     * @ORM\Column(name="code_dept", type="string", length=2, nullable=true)
     */
    private $codeDept;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_dept", type="string", length=40, nullable=true)
     */
    private $nomDept;

    /**
     * @var integer
     *
     * @ORM\Column(name="code_reg", type="integer", nullable=true)
     */
    private $codeReg;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_region", type="string", length=40, nullable=true)
     */
    private $nomRegion;

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
    public function getInsee()
    {
        return $this->insee;
    }

    /**
     * @param int $see
     * @return Communes
     */
    public function setInsee($insee)
    {
        $this->insee = $insee;
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
     * @return Communes
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * @return string
     */
    public function getWikipedia()
    {
        return $this->wikipedia;
    }

    /**
     * @param string $wikipedia
     * @return Communes
     */
    public function setWikipedia($wikipedia)
    {
        $this->wikipedia = $wikipedia;
        return $this;
    }

    /**
     * @return int
     */
    public function getSurfM2()
    {
        return $this->surfM2;
    }

    /**
     * @param int $surfM2
     * @return Communes
     */
    public function setSurfM2($surfM2)
    {
        $this->surfM2 = $surfM2;
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
     * @return Communes
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
     * @return Communes
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
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
     * @return Communes
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;
        return $this;
    }

    /**
     * @return int
     */
    public function getXChfLieu()
    {
        return $this->xChfLieu;
    }

    /**
     * @param int $xChfLieu
     * @return Communes
     */
    public function setXChfLieu($xChfLieu)
    {
        $this->xChfLieu = $xChfLieu;
        return $this;
    }

    /**
     * @return int
     */
    public function getYChfLieu()
    {
        return $this->yChfLieu;
    }

    /**
     * @param int $yChfLieu
     * @return Communes
     */
    public function setYChfLieu($yChfLieu)
    {
        $this->yChfLieu = $yChfLieu;
        return $this;
    }

    /**
     * @return int
     */
    public function getZMoyen()
    {
        return $this->zMoyen;
    }

    /**
     * @param int $zMoyen
     * @return Communes
     */
    public function setZMoyen($zMoyen)
    {
        $this->zMoyen = $zMoyen;
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
     * @return Communes
     */
    public function setPopulation($population)
    {
        $this->population = $population;
        return $this;
    }

    /**
     * @return int
     */
    public function getCodeCant()
    {
        return $this->codeCant;
    }

    /**
     * @param int $codeCant
     * @return Communes
     */
    public function setCodeCant($codeCant)
    {
        $this->codeCant = $codeCant;
        return $this;
    }

    /**
     * @return int
     */
    public function getCodeArr()
    {
        return $this->codeArr;
    }

    /**
     * @param int $codeArr
     * @return Communes
     */
    public function setCodeArr($codeArr)
    {
        $this->codeArr = $codeArr;
        return $this;
    }

    /**
     * @return string
     */
    public function getCodeDept()
    {
        return $this->codeDept;
    }

    /**
     * @param string $codeDept
     * @return Communes
     */
    public function setCodeDept($codeDept)
    {
        $this->codeDept = $codeDept;
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
     * @return Communes
     */
    public function setNomDept($nomDept)
    {
        $this->nomDept = $nomDept;
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
     * @return Communes
     */
    public function setCodeReg($codeReg)
    {
        $this->codeReg = $codeReg;
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
     * @return Communes
     */
    public function setNomRegion($nomRegion)
    {
        $this->nomRegion = $nomRegion;
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
     * @return Communes
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }


}

