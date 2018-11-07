<?php

namespace App\Models\Repositories;

use Doctrine\ORM\Query;

class UsersPagosContabilidadRepository extends EntityRepository {

    public function getUltimoPago($user) {
        $qb = $this->createQueryBuilder('p');

        $qb
            ->andWhere('p.user = :user')
            ->setParameter('user', $user)
            ->setMaxResults(1)
            ->orderBy('p.id', 'DESC')
        ;

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function getUpdatePlanes() {
        $qb = $this->createQueryBuilder('p');

        $fechaTermino = \Carbon\Carbon::now();

        $qb
            ->andWhere('p.estatusNuevo = :estatusNuevo')
            ->setParameter('estatusNuevo', 'PENDIENTE')
            ->andWhere('p.fechaTermino < :fechaTermino')
            ->setParameter('fechaTermino', $fechaTermino->format('Y-m-d'))
        ;

        return $qb->getQuery()->getResult();
    }

    public function getPlanPendiente($user) {
        $qb = $this->createQueryBuilder('p');

        $qb
            ->andWhere('p.user = :user')
            ->setParameter('user', $user)
            ->andWhere('p.estatusNuevo = :estatusNuevo')
            ->setParameter('estatusNuevo', 'PENDIENTE')
        ;

        return $qb->getQuery()->getOneOrNullResult();
    }
}
