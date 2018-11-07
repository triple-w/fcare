<?php

namespace App\Models\Repositories;

use Doctrine\ORM\Query;

class ComplementosRepository extends EntityRepository {

    public function getComplementos($user) {
        $qb = $this->createQueryBuilder('c');

        $qb
        ->andWhere('c.user = :user')
        ->setParameter('user', $user)
        ;

        return $qb->getQuery()->getResult();
    }

    public function getUltimoPago($id) {
        $qb = $this->createQueryBuilder('p');

        $qb->select('saldo_insoluto')
        ->where('p.documento_id = :id')
        ->orderBy('p.id', 'DESC')
        ->setMaxResults(1)
        ->setParameter('id', $id);

        return $qb->getQuery()->getResult();
        //SELECT `saldo_insoluto` FROM `complementos_pagos` WHERE `documento_id` = '' ORDER BY `documento_id` DESC LIMIT 1//
    }

}
