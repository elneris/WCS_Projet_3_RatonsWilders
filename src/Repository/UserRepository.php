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

    public function filter($result)
    {
        return $this->createQueryBuilder('user')
            ->join('user.activities', 'activities')
            ->where('activities.domain = :activitiesDomain')
            ->andWhere('activities.style = :activitiesStyle')
            ->andWhere('activities.skill = :activitiesSkill')
            ->setParameter("activitiesDomain", $result['metier'])
            ->setParameter("activitiesStyle", $result['style'])
            ->setParameter("activitiesSkill", $result['skill'])
            ->getQuery()
            ->getResult();
    }

    public function filterOnlyByDomain($result)
    {
        return $this->createQueryBuilder('user')
            ->join('user.activities', 'activities')
            ->where('activities.domain = :activitiesDomain')
            ->setParameter("activitiesDomain", $result['metier'])
            ->getQuery()
            ->getResult();
    }

    public function filterByStyle($result)
    {
        return $this->createQueryBuilder('user')
            ->join('user.activities', 'activities')
            ->where('activities.domain = :activitiesDomain')
            ->andWhere('activities.style = :activitiesStyle')
            ->setParameter("activitiesDomain", $result['metier'])
            ->setParameter("activitiesStyle", $result['style'])
            ->getQuery()
            ->getResult();
    }

    public function filterBySkill($result)
    {
        return $this->createQueryBuilder('user')
            ->join('user.activities', 'activities')
            ->where('activities.domain = :activitiesDomain')
            ->andWhere('activities.skill = :activitiesSkill')
            ->setParameter("activitiesDomain", $result['metier'])
            ->setParameter("activitiesSkill", $result['skill'])
            ->getQuery()
            ->getResult();
    }


    /**
     * @param string $value
     * @return User[] Returns an array of User objects
     */
    public function searchByNames(string $value = null)
    {
        return $this->createQueryBuilder('u')
            ->where('u.lastname LIKE :val')
            ->orWhere('u.firstname LIKE :val')
            ->orWhere('u.artistName LIKE :val')
            ->setParameter('val', '%'.$value.'%')
            ->orderBy('u.id', 'ASC')
            ->getQuery()
            ->getResult();
    }


    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
