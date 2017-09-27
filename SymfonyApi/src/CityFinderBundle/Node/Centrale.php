<?php

namespace CityFinderBundle\Node;


use GraphAware\Neo4j\OGM\Annotations as OGM;

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
     * @var string
     *
     * @OGM\Property(type="string")
     */
    protected $name;

    /**
     * @var float
     *
     * @OGM\Property(type="float")
     */
    protected $latitude;

    /**
     * @var float
     *
     * @OGM\Property(type="float")
     */
    protected $longitude;



}