<?php

namespace CityFinderBundle\Node;


use GraphAware\Neo4j\OGM\Annotations as OGM;
use GraphAware\Neo4j\OGM\Common\Collection;

/**
 *
 * @OGM\Node(label="Centrale")
 */
class Centrale
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
     ** @OGM\Property(type="int")
     */
    protected $doctrineId;
    /**
     * @var string
     *
     * @OGM\Property(type="string")
     */
    protected $name;

    /**
     * @var int
     *
     * @OGM\Property(type="string")
     */
    protected $nombreReacteur;

    /**
     * @var Commune[]|Collection
     *
     * @OGM\Relationship(type="NEAR_80KM_FROM", direction="INCOMING", collection=true, mappedBy="centralesNear80km", targetEntity="Commune")
     */
    protected $communesNear80km;

    /**
     * @var Commune[]|Collection
     *
     * @OGM\Relationship(type="NEAR_30KM_FROM", direction="INCOMING", collection=true, mappedBy="centralesNear50km", targetEntity="Commune")
     */
    protected $communesNear30km;

    /**
     * @var Commune[]|Collection
     *
     * @OGM\Relationship(type="NEAR_20KM_FROM", direction="INCOMING", collection=true, mappedBy="centralesNear20km", targetEntity="Commune")
     */
    protected $communesNear20km;
    /**
     * Centrale constructor.
     */
    public function __construct()
    {
        $this->communesNear80km = new Collection();
        $this->communesNear30km = new Collection();
        $this->communesNear20km = new Collection();
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
     * @return Centrale
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @return Centrale
     */
    public
    function setDoctrineId($doctrineId)
    {
        $this->doctrineId = $doctrineId;
        return $this;
    }

    /**
     * @return string
     */
    public
    function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Centrale
     */
    public
    function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public
    function getNombreReacteur()
    {
        return $this->nombreReacteur;
    }

    /**
     * @param int $nombreReacteur
     * @return Centrale
     */
    public
    function setNombreReacteur($nombreReacteur)
    {
        $this->nombreReacteur = $nombreReacteur;
        return $this;
    }

    /**
     * @return Collection|Commune[]
     */
    public
    function getCommunesNear80km()
    {
        return $this->communesNear80km;
    }

    /**
     * @param Collection|Commune[] $communesNear80km
     */
    public
    function setCommunesNear80km($communesNear80km)
    {
        $this->communesNear80km = $communesNear80km;
        return $this;
    }

    /**
     * @return Commune[]|Collection
     */
    public function getCommunesNear30km()
    {
        return $this->communesNear30km;
    }

    /**
     * @param Commune[]|Collection $communesNear30km
     */
    public function setCommunesNear30km($communesNear30km)
    {
        $this->communesNear30km = $communesNear30km;
        return $this;
    }


    /**
     * @return Commune[]|Collection
     */
    public function getCommunesNear20km()
    {
        return $this->communesNear20km;
    }

    /**
     * @param Commune[]|Collection $communesNear20km
     */
    public function setCommunesNear20km($communesNear20km)
    {
        $this->communesNear20km = $communesNear20km;
        return $this;
    }
}
