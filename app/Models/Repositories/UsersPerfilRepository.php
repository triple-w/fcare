<?php

namespace App\Models\Repositories;

use Doctrine\ORM\Query;

class UsersPerfilRepository extends EntityRepository {

    public function getUsersVerificarCiec() {
        $qb = $this->createQueryBuilder('p');

        $qb
            ->andWhere('p.verificarCiec = :verificarCiec')
            ->setParameter('verificarCiec', true)
        ;

        return $qb->getQuery()->getResult();
    }

}
