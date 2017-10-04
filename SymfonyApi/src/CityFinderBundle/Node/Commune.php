<?php

namespace CityFinderBundle\Node;


use GraphAware\Neo4j\OGM\Annotations as OGM;
use GraphAware\Neo4j\OGM\Common\Collection;

/**
 *
 * @OGM\Node(label="Commune")
 */
class Commune
{

    /**
     * @var int
     *
     * @OGM\GraphId()
     */
    protected $id;

    /**
     * @var int
     *
     * @OGM\Property(type="int")
     */
    protected $doctrineId;

    /**
     * @var string
     *
     * @OGM\Property(type="string")
     */
    protected $name;

    /**
     * @var string
     *
     * @OGM\Property(type="string")
     */
    protected $nomRegion;

    /**
     * @var string
     *
     * @OGM\Property(type="int")
     */
    protected $codeRegion;

    /**
     * @var string
     *
     * @OGM\Property(type="int")
     */
    protected $codeDepartement;

    /**
     * @var string
     *
     * @OGM\Property(type="string")
     */
    protected $nomDepartement;

    /**
     * @var Centrale[]|Collection
     *
     * @OGM\Relationship(type="NEAR_80KM_FROM", direction="OUTGOING", collection=true, mappedBy="communesNear80km", targetEntity="Centrale")
     */
    protected $centralesNear80km;


    /**
     * @var Centrale[]|Collection
     *
     * @OGM\Relationship(type="NEAR_30KM_FROM", direction="OUTGOING", collection=true, mappedBy="communesNear30km", targetEntity="Centrale")
     */
    protected $centralesNear30km;

    /**
     * @var Centrale[]|Collection
     *
     * @OGM\Relationship(type="NEAR_20KM_FROM", direction="OUTGOING", collection=true, mappedBy="communesNear20km", targetEntity="Centrale")
     */
    protected $centralesNear20km;



    /**
     * @var Commune[]|Collection
     *
     * @OGM\Relationship(type="NEAR", direction="INCOMING", collection=true, mappedBy="communesNear", targetEntity="Hotel")
     */
    protected $hotelsNear;

    /**
     * @var Commune[]|Collection
     *
     * @OGM\Relationship(type="LOCATED_IN", direction="INCOMING", collection=true, mappedBy="communesLocatedIn", targetEntity="Hotel")
     */
    protected $hotelsLocatedIn;


    /**
     * @var Musee[]|Collection
     *
     * @OGM\Relationship(type="LOCATED_IN", direction="INCOMING", collection=true, mappedBy="communesLocatedIn", targetEntity="Musee")
     */
    protected $museesLocatedIn;


    /**
     * @var AgencePostale[]|Collection
     *
     * @OGM\Relationship(type="LOCATED_IN", direction="INCOMING", collection=true, mappedBy="communesLocatedIn", targetEntity="AgencePostale")
     */
    protected $agencesPostalesLocatedIn;


    /**
     * Commune constructor.
     */
    public function __construct()
    {
        $this->centralesNear80km            = new Collection();
        $this->centralesNear30km            = new Collection();
        $this->centralesNear20km            = new Collection();
        $this->hotelsNear                   = new Collection();
        $this->hotelsLocatedIn              = new Collection();
        $this->museesLocatedIn              = new Collection();
        $this->agencesPostalesLocatedIn     = new Collection();
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
     * @return Commune
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Commune
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * @return Commune
     */
    public function setNomRegion($nomRegion)
    {
        $this->nomRegion = $nomRegion;
        return $this;
    }

    /**
     * @return string
     */
    public function getCodeRegion()
    {
        return $this->codeRegion;
    }

    /**
     * @param string $codeRegion
     * @return Commune
     */
    public function setCodeRegion($codeRegion)
    {
        $this->codeRegion = $codeRegion;
        return $this;
    }

    /**
     * @return string
     */
    public function getCodeDepartement()
    {
        return $this->codeDepartement;
    }

    /**
     * @param string $codeDepartement
     * @return Commune
     */
    public function setCodeDepartement($codeDepartement)
    {
        $this->codeDepartement = $codeDepartement;
        return $this;
    }

    /**
     * @return string
     */
    public function getNomDepartement()
    {
        return $this->nomDepartement;
    }

    /**
     * @param string $nomDepartement
     * @return Commune
     */
    public function setNomDepartement($nomDepartement)
    {
        $this->nomDepartement = $nomDepartement;
        return $this;
    }

    /**
     * @return int
     */
    public function getDoctrineId()
    {
        return $this->doctrineId;
    }

    /**
     * @param int $doctrineId
     * @return Commune
     */
    public function setDoctrineId($doctrineId)
    {
        $this->doctrineId = $doctrineId;
        return $this;
    }


    /**
     * @return Centrale[]|Collection
     */
    public function getCentralesNear80km()
    {
        return $this->centralesNear80km;
    }

    /**
     * @param Centrale[]|Collection $centralesNear80km
     */
    public function setCentralesNear80km($centralesNear80km)
    {
        $this->centralesNear80km = $centralesNear80km;
        return $this;
    }

    /**
     * @return Centrale[]|Collection
     */
    public function getCentralesNear30km()
    {
        return $this->centralesNear30km;
    }

    /**
     * @param Centrale[]|Collection $centralesNear30km
     */
    public function setCentralesNear30km($centralesNear30km)
    {
        $this->centralesNear30km = $centralesNear30km;
        return $this;
    }

    /**
     * @return Centrale[]|Collection
     */
    public function getCentralesNear20km()
    {
        return $this->centralesNear20km;
    }

    /**
     * @param Centrale[]|Collection $centralesNear20km
     */
    public function setCentralesNear20km($centralesNear20km)
    {
        $this->centralesNear20km = $centralesNear20km;
        return $this;
    }

    /**
     * @return Commune[]|Collection
     */
    public function getHotelsNear()
    {
        return $this->hotelsNear;
    }

    /**
     * @param Commune[]|Collection $hotelsNear
     * @return Commune
     */
    public function setHotelsNear($hotelsNear)
    {
        $this->hotelsNear = $hotelsNear;
        return $this;
    }

    /**
     * @return Commune[]|Collection
     */
    public function getHotelsLocatedIn()
    {
        return $this->hotelsLocatedIn;
    }

    /**
     * @param Commune[]|Collection $hotelsLocatedIn
     * @return Commune
     */
    public function setHotelsLocatedIn($hotelsLocatedIn)
    {
        $this->hotelsLocatedIn = $hotelsLocatedIn;
        return $this;
    }

    /**
     * @return Musee[]|Collection
     */
    public function getMuseesLocatedIn()
    {
        return $this->museesLocatedIn;
    }

    /**
     * @param Musee[]|Collection $museesLocatedIn
     * @return Commune
     */
    public function setMuseesLocatedIn($museesLocatedIn)
    {
        $this->museesLocatedIn = $museesLocatedIn;
        return $this;
    }

    /**
     * @return AgencePostale[]|Collection
     */
    public function getAgencesPostalesLocatedIn()
    {
        return $this->agencesPostalesLocatedIn;
    }

    /**
     * @param AgencePostale[]|Collection $agencesPostalesLocatedIn
     * @return Commune
     */
    public function setAgencesPostalesLocatedIn($agencesPostalesLocatedIn)
    {
        $this->agencesPostalesLocatedIn = $agencesPostalesLocatedIn;
        return $this;
    }




}