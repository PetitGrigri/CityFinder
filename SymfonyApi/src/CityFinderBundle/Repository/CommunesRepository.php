<?php
namespace CityFinderBundle\Repository;

use CityFinderBundle\Entity\Communes;
use Doctrine\ORM\EntityRepository;

class CommunesRepository extends EntityRepository
{
    public function findCommuneLike($commune)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        return $qb
            ->select('c')
            ->from(Communes::class, 'c')
            ->where( $qb->expr()->like('c.nom', ':commune'))
            ->setParameter('commune','%'.str_replace(" ",'%',$commune).'%')
            ->setMaxResults(501)
            ->getQuery()
            ->getResult();
    }
}