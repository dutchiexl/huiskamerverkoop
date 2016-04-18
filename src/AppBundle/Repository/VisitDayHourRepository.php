<?php

namespace AppBundle\Repository;
use Doctrine\Common\Collections\Criteria;

/**
 * VisitDayHourRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class VisitDayHourRepository extends \Doctrine\ORM\EntityRepository
{
    public function getAvailableVisits(){
        $qb = $this->createQueryBuilder('v')
            ->select('v')
            ->join('v.subscribers', 's')
            ->groupBy('v.id')
            ->having('(v.places - count(v.id)) > 0')
            ->getQuery();
        return $qb->getResult();

    }
}
