<?php

namespace App\Models\Repositories;

use Doctrine\ORM\Query;

class ClaveProdServRepository extends EntityRepository {

    public function search($data, $limit) {
        $qb = $this->createQueryBuilder('c');

        $qb
        ->select([ 'c.id', 'c.descripcion' ])
        ->andWhere('c.descripcion LIKE :descripcion')
        ->setParameter('descripcion', "%{$data}%")
        ->setMaxResults($limit);
        ;

        return $qb->getQuery()->getResult();
    }

}
