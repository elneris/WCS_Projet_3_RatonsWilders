<?php

namespace App\Repository;

use App\Entity\Domain;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @method Domain|null find($id, $lockMode = null, $lockVersion = null)
 * @method Domain|null findOneBy(array $criteria, array $orderBy = null)
 * @method Domain[]    findAll()
 * @method Domain[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DomainRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Domain::class);
    }

    public function findAllPaginationAndTrie($page, $nbMaxByPage)
    {
        if (!is_numeric($page)) {
            throw new \InvalidArgumentException(
                'La valeur de la page est incorrecte'
            );
        }

        if ($page < 1) {
            throw new \InvalidArgumentException(
                'La page demandée n\'existe pas'
            );
        }

        if (!is_numeric($nbMaxByPage)) {
            throw new \InvalidArgumentException(
                'La valeur de la page max est incorrecte'
            );
        }

        $qb = $this->createQueryBuilder('domain')
            ->orderBy('domain.name', 'ASC');

        $query = $qb->getQuery();

        $firstResult = ($page - 1) * $nbMaxByPage;
        $query->setFirstResult($firstResult)->setMaxResults($nbMaxByPage);

        $paginator = new Paginator($query);

        if (($paginator->count() <= $firstResult) && $page != 1) {
            throw new NotFoundHttpException('La page demandée n\'existe pas.');
        }

        return $paginator;
    }
}
