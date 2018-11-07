<?php

namespace App\Models\Repositories;

use Doctrine\ORM\Query;

class ComplementosPagosRepository extends EntityRepository {

    public function getUltimoPago($id) {
        $qb = $this->createQueryBuilder('p');

        $qb->select('p.saldoInsoluto')
        ->where('p.documentoId = :id')
        ->orderBy('p.id', 'DESC')
        ->setMaxResults(1)
        ->setParameter('id', $id);

        return $qb->getQuery()->getResult();
        //SELECT `saldo_insoluto` FROM `complementos_pagos` WHERE `documento_id` = '' ORDER BY `documento_id` DESC LIMIT 1//
    }

}
