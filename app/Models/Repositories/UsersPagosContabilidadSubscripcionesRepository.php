<?php

namespace App\Models\Repositories;

use Doctrine\ORM\Query;

class UsersPagosContabilidadSubscripcionesRepository extends EntityRepository {

    public function getUltimaSubscripcion($user) {
        $qb = $this->createQueryBuilder('s');

        $qb
            ->innerJoin('s.pagoContabilidad', 'p')
            ->andWhere('p.user = :user')
            ->setParameter('user', $user)
            ->setMaxResults(1)
            ->orderBy('s.id', 'DESC')
        ;

        return $qb->getQuery()->getOneOrNullResult();
    }
}
