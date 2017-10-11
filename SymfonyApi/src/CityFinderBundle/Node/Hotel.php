<?php

namespace CityFinderBundle\Node;


use GraphAware\Neo4j\OGM\Annotations as OGM;
use GraphAware\Neo4j\OGM\Common\Collection;

/**
 *
 * @OGM\Node(label="Hotel")
 */
class Hotel
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
    protected $classement;


    /**
     * @var Hotel[]|Collection
     *
     * @OGM\Relationship(type="NEAR", direction="OUTGOING", collection=true, mappedBy="hotelsNear", targetEntity="Commune")
     */
    protected $communesNear;

    /**
     * @var Hotel[]|Collection
     *
     * @OGM\Relationship(type="LOCATED_IN", direction="OUTGOING", collection=true, mappedBy="hotelsLocatedIn", targetEntity="Commune")
     */
    protected $communesLocatedIn;


    public function __construct()
    {
        $this->communesNear         = new Collection();
        $this->communesLocatedIn    = new Collection();
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
     */
    public function setId($id)
    {
        $this->id = $id;
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
     */
    public function setDoctrineId($doctrineId)
    {
        $this->doctrineId = $doctrineId;
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
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getClassement()
    {
        return $this->classement;
    }

    /**
     * @param int $classement
     */
    public function setClassement($classement)
    {
        $this->classement = $classement;
    }

    /**
     * @return Hotel[]|Collection
     */
    public function getCommunesNear()
    {
        return $this->communesNear;
    }

    /**
     * @param Hotel[]|Collection $communesNear
     */
    public function setCommunesNear($communesNear)
    {
        $this->communesNear = $communesNear;
    }

    /**
     * @return Hotel[]|Collection
     */
    public function getCommunesLocatedIn()
    {
        return $this->communesLocatedIn;
    }

    /**
     * @param Hotel[]|Collection $communesLocatedIn
     */
    public function setCommunesLocatedIn($communesLocatedIn)
    {
        $this->communesLocatedIn = $communesLocatedIn;
    }



}
