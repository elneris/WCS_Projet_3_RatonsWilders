<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findLastTenUsers()
    {
        return $this->createQueryBuilder('u')
                    ->where('u.roles LIKE :role')
                    ->setParameter('role', '%"'.'ROLE_USER'.'"%')
                    ->orderBy('u.id', 'DESC')
                    ->setMaxResults(10)
                    ->getQuery()->getResult();
    }

    public function myFilter($filters)
    {
        $qb = $this->createQueryBuilder('user')
                    ->join('user.activities', 'activities')
        ;

        if ($filters['metier']) {
            $qb->andWhere('activities.domain = :activitiesDomain')
                ->setParameter("activitiesDomain", $filters['metier']);
        }

        if ($filters['skill']) {
            $qb->andWhere('activities.skill = :activitiesSkill')
               ->setParameter("activitiesSkill", $filters['skill']);
        }

        if ($filters['style']) {
            $qb->andWhere('activities.style = :activitiesStyle')
                ->setParameter("activitiesStyle", $filters['style']);
        }
        if ($filters['zone']) {
            $qb->andWhere('user.geoArea = :geoArea')
                ->setParameter("geoArea", $filters['zone']);
        }

        if ($filters['searchField']) {
            $qb->orHaving('user.lastname LIKE :val')
                ->orHaving('user.firstname LIKE :val')
                ->orHaving('user.artistName LIKE :val')
                ->orHaving('user.email LIKE :val')
                ->setParameter('val', '%'.$filters['searchField'].'%');
        }

        return $qb->getQuery()->getResult();
    }
}
