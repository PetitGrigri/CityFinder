<?php

namespace CityFinderBundle\Node;


use GraphAware\Neo4j\OGM\Annotations as OGM;

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

}