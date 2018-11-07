<?php

namespace App\Models\Repositories;

use Doctrine\ORM\Query;

class UsersPeriodosDocumentosRepository extends EntityRepository {

    public function getPagados($id) {
        $qb = $this->createQueryBuilder('d');

        $user = \Auth::user();

        $qb
            ->innerJoin('d.periodo', 'p')
            ->andWhere('p.user = :user')
            ->setParameter('user', $user)
            ->andWhere('d.periodo = :id')
            ->setParameter('id', $id)
            ->andWhere('d.estatus = :estatus')
            ->setParameter('estatus', \App\Models\UsersPeriodosDocumentos::PAGADO)
        ;

        return $qb->getQuery()->getResult();
    }

    public function getEmitidos($id) {
        $qb = $this->createQueryBuilder('d');

        $user = \Auth::user();

        $qb
            ->innerJoin('d.periodo', 'p')
            ->andWhere('p.user = :user')
            ->setParameter('user', $user)
            ->andWhere('d.periodo = :id')
            ->setParameter('id', $id)
            ->andWhere('d.tipo = :tipo')
            ->setParameter('tipo', \App\Models\UsersPeriodosDocumentos::EMITIDO)
        ;

        return $qb->getQuery()->getResult();
    }

    public function getRecibidos($id) {
        $qb = $this->createQueryBuilder('d');

        $user = \Auth::user();

        $qb
            ->innerJoin('d.periodo', 'p')
            ->andWhere('p.user = :user')
            ->setParameter('user', $user)
            ->andWhere('d.periodo = :id')
            ->setParameter('id', $id)
            ->andWhere('d.tipo = :tipo')
            ->setParameter('tipo', \App\Models\UsersPeriodosDocumentos::RECIBIDO)
        ;

        return $qb->getQuery()->getResult();
    }

    public function getEmitidosAnteriores($id) {
        $qb = $this->createQueryBuilder('d');

        $user = \Auth::user();

        $qb
            ->innerJoin('d.periodo', 'p')
            ->andWhere('p.user = :user')
            ->setParameter('user', $user)
            ->andWhere('d.periodo != :id')
            ->setParameter('id', $id)
            ->andWhere('d.estatus = :estatus')
            ->setParameter('estatus', 'NUEVO')
            ->andWhere('d.tipo = :tipo')
            ->setParameter('tipo', \App\Models\UsersPeriodosDocumentos::EMITIDO)
        ;

        return $qb->getQuery()->getResult();
    }

    public function getRecibidosAnteriores($id) {
        $qb = $this->createQueryBuilder('d');

        $user = \Auth::user();

        $qb
            ->innerJoin('d.periodo', 'p')
            ->andWhere('p.user = :user')
            ->setParameter('user', $user)
            ->andWhere('d.periodo != :id')
            ->setParameter('id', $id)
            ->andWhere('d.estatus = :estatus')
            ->setParameter('estatus', 'NUEVO')
            ->andWhere('d.tipo = :tipo')
            ->setParameter('tipo', \App\Models\UsersPeriodosDocumentos::RECIBIDO)
        ;

        return $qb->getQuery()->getResult();
    }

    public function getMovimientos($mes, $anio, $user) {
        $qb = $this->createQueryBuilder('d');

        $qb
            ->innerJoin('d.pagos', 'pa')
            ->innerJoin('d.periodo', 'p')
            ->innerJoin('p.user', 'u')
            ->andWhere('u.id = :user')
            ->setParameter('user', $user)
            ->andWhere('MONTH(pa.fechaPago) = :mes')
            ->setParameter('mes', $mes)
            ->andWhere('YEAR(pa.fechaPago) = :anio')
            ->setParameter('anio', $anio)
        ;

        return $qb->getQuery()->getResult();
    }

}
