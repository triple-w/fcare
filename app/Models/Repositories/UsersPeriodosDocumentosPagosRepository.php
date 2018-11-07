<?php

namespace App\Models\Repositories;

use Doctrine\ORM\Query;

class UsersPeriodosDocumentosPagosRepository extends EntityRepository {

    public function getMovimientos($mes, $anio, $user) {
        $qb = $this->createQueryBuilder('p');

        $qb
            ->innerJoin('p.documento', 'd')
            ->innerJoin('d.periodo', 'pe')
            ->innerJoin('pe.user', 'u')
            ->andWhere('u.id = :user')
            ->setParameter('user', $user)
            ->andWhere('MONTH(p.fechaPago) = :mes')
            ->setParameter('mes', $mes)
            ->andWhere('YEAR(p.fechaPago) = :anio')
            ->setParameter('anio', $anio)
        ;

        return $qb->getQuery()->getResult();
    }

    public function getMovimientosEmitidos($mes, $anio, $user) {
        $qb = $this->createQueryBuilder('p');

        $qb
            ->innerJoin('p.documento', 'd')
            ->innerJoin('d.periodo', 'pe')
            ->innerJoin('pe.user', 'u')
            ->andWhere('u.id = :user')
            ->setParameter('user', $user)
            ->andWhere('MONTH(p.fechaPago) = :mes')
            ->setParameter('mes', $mes)
            ->andWhere('YEAR(p.fechaPago) = :anio')
            ->setParameter('anio', $anio)
            ->andWhere('d.tipo = :tipo')
            ->setParameter('tipo', \App\Models\UsersPeriodosDocumentos::EMITIDO)
        ;

        return $qb->getQuery()->getResult();
    }

    public function getMovimientosRecibidos($mes, $anio, $user) {
        $qb = $this->createQueryBuilder('p');

        $qb
            ->innerJoin('p.documento', 'd')
            ->innerJoin('d.periodo', 'pe')
            ->innerJoin('pe.user', 'u')
            ->andWhere('u.id = :user')
            ->setParameter('user', $user)
            ->andWhere('MONTH(p.fechaPago) = :mes')
            ->setParameter('mes', $mes)
            ->andWhere('YEAR(p.fechaPago) = :anio')
            ->setParameter('anio', $anio)
            ->andWhere('d.tipo = :tipo')
            ->setParameter('tipo', \App\Models\UsersPeriodosDocumentos::RECIBIDO)
        ;

        return $qb->getQuery()->getResult();
    }
}
