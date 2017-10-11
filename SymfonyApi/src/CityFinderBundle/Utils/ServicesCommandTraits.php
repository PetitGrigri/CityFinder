<?php

namespace CityFinderBundle\Utils;


trait ServicesCommandTraits
{
    /**
     * @return \GraphAware\Neo4j\Client\Client
     */
    protected function getNeo4jClient()
    {
        return $this->getContainer()->get('neo4j.client');
    }

    /**
     * @return \Doctrine\Bundle\DoctrineBundle\Registry
     */
    protected function getDoctrineClient()
    {
        return $this->getContainer()->get('doctrine');
    }

    /**
     * @return \GraphAware\Neo4j\OGM\EntityManager object
     */
    private function getNeo4jEntityManager() {
        return $this->getContainer()->get('neo4j.entity_manager.default');
    }

    /**
     * @return \Symfony\Component\Cache\Adapter\TraceableAdapter
     */
    private function getMemCachedAdapter() {
        return $this->getContainer()->get('app.cache.products');
    }
}
