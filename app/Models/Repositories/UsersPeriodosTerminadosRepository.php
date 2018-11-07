<?php

namespace App\Models\Repositories;

use Doctrine\ORM\Query;

class UsersPeriodosTerminadosRepository extends EntityRepository {

    public function getPeriodos() {
        $qb = $this->createQueryBuilder('t');

        $qb
        ->andWhere('t.revisado = :revisado')
        ->setParameter('revisado', false)
        ;

        return $qb->getQuery()->getResult();
    }
}
