<?php

namespace CityFinderBundle\Node;


use GraphAware\Neo4j\OGM\Annotations as OGM;
use GraphAware\Neo4j\OGM\Common\Collection;

/**
 *
 * @OGM\Node(label="AgencePostale")
 */
class AgencePostale
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
     * @var string
     *
     * @OGM\Property(type="string")
     */
    protected $caracteristiqueSite;


    /**
     * @var Commune[]|Collection
     *
     * @OGM\Relationship(type="LOCATED_IN", direction="OUTGOING", collection=true, mappedBy="agencesPostalesLocatedIn", targetEntity="Commune")
     */
    protected $communesLocatedIn;


    public function __construct()
    {
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
     * @return string
     */
    public function getCaracteristiqueSite()
    {
        return $this->caracteristiqueSite;
    }

    /**
     * @param string $caracteristiqueSite
     * @return AgencePostale
     */
    public function setCaracteristiqueSite($caracteristiqueSite)
    {
        $this->caracteristiqueSite = $caracteristiqueSite;
        return $this;
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
