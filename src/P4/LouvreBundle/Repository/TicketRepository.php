<?php

namespace P4\LouvreBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * TicketRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TicketRepository extends EntityRepository
{
    public function getNbTicketsPerDay()
    {
        $startDay = \DateTime::createFromFormat( "Y-m-d H:i:s", date("Y-m-d 00:00:00") );
        $endDay = \DateTime::createFromFormat( "Y-m-d H:i:s", date("Y-m-d 23:59:59") );
        $qb = $this
            ->createQueryBuilder('t')
            ->select('COUNT(t)')
            ->innerJoin('t.booking', 'b')
            ->where('b.visitDate >= :start_day')
            ->andWhere('b.visitDate <= :end_day')
            ->setParameter('start_day', $startDay)
            ->setParameter('end_day', $endDay)
        ;
        return $qb->getQuery()->getSingleScalarResult();
    }

}

