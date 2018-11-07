<?php

namespace App\Models\Repositories;

use Doctrine\ORM\Query;

class FacturasRepository extends EntityRepository {

    public function getFacturas($data) {
        $qb = $this->createQueryBuilder('f');

        $qb
        ->andWhere('f.fechaFactura BETWEEN :inicial AND :final')
        ->setParameter('inicial', $data['fechaInicial'] . ' 00:00:00')
        ->setParameter('final', $data['fechaFinal'] . ' 23:59:00')
        ->andWhere('f.user = :user')
        ->setParameter('user', \Auth::user())
        ;

        if ($data['cliente'] !== 'TODOS') {
            $qb
            ->andWhere('f.rfc = :cliente')
            ->setParameter('cliente', $data['cliente'])
            ;
        }

        if ($data['estatus'] !== 'TODOS') {
            $qb
            ->andWhere('f.estatus = :estatus')
            ->setParameter('estatus', $data['estatus'])
            ;
        }

        if ($data['nombreComprobante'] !== 'TODOS') {
            $qb
            ->andWhere('f.nombreComprobante = :comprobante')
            ->setParameter('comprobante', $data['nombreComprobante'])
            ;
        }

        return $qb->getQuery()->getResult();
    }

    public function getGeneradosEsteMes() {
        $qb = $this->createQueryBuilder('f');

        $hoy = \Carbon\Carbon::now();
        $mes = $hoy->month;
        $user = \Auth::user();

        $qb
        ->select('COUNT(f.id)')
        ->andWhere('MONTH(f.fechaFactura) = :mes')
        ->setParameter('mes', $mes)
        ->andWhere('f.user = :user')
        ->setParameter('user', $user)
        ;

        return intval($qb->getQuery()->getSingleScalarResult());
    }

}
