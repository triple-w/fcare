<?php

namespace App\Models\Repositories;

use Doctrine\ORM\Query;

class NominasRepository extends EntityRepository {

    public function getGeneradosEsteMes() {
        $qb = $this->createQueryBuilder('n');

        $hoy = \Carbon\Carbon::now();
        $mes = $hoy->month;

        $qb
        ->select('COUNT(n.id)')
        ->andWhere('MONTH(n.fecha) = :mes')
        ->setParameter('mes', $mes)
        ;

        return intval($qb->getQuery()->getSingleScalarResult());
    }

}
