<?php

namespace App\Extensions\Doctrine\Auth;

use Illuminate\Contracts\Hashing\Hasher;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineUserProvider extends \LaravelDoctrine\ORM\Auth\DoctrineUserProvider
{
    
    /**
     * @param Hasher                 $hasher
     * @param EntityManagerInterface $em
     * @param string                 $entity
     */
    public function __construct(Hasher $hasher, EntityManagerInterface $em, $entity)
    {
        parent::__construct($hasher, $em, $entity);
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param array $credentials
     *
     * @return IlluminateAuthenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        $qb = $this->em->createQueryBuilder();
        $qb ->select('u')
            ->from('App\Models\Users', 'u');

        foreach ($credentials as $key => $value) {
            if ($key === 'email_username') {
                $qb->where($qb->expr()->orX(
                        //$qb->expr()->eq('u.email', ':email_username'),
                        $qb->expr()->eq('u.username', ':email_username')
                    ));
                $qb->setParameters([ 'email_username' => $value ]);
            } else {
                if (!str_contains($key, 'password')) {
                    $qb->andWhere("u.{$key}=:{$key}");
                    $qb->setParameter($key, $value);
                }
            }
        }

        return $qb->getQuery()->getOneOrNullResult();
    }
    
}
