<?php

namespace CityFinderBundle\Utils;


trait ServicesControllerTraits
{
    /**
     * @return \GraphAware\Neo4j\Client\Client
     */
    protected function getNeo4jClient()
    {
        return $this->get('neo4j.client');
    }

    /**
     * @return \Doctrine\Bundle\DoctrineBundle\Registry
     */
    protected function getDoctrineClient()
    {
        return $this->get('doctrine');
    }

    /**
     * @return \GraphAware\Neo4j\OGM\EntityManager object
     */
    private function getNeo4jEntityManager() {
        return $this->get('neo4j.entity_manager.default');
    }
}