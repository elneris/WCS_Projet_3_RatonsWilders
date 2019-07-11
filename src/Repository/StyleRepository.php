<?php

namespace App\Repository;

use App\Entity\Style;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @method Style|null find($id, $lockMode = null, $lockVersion = null)
 * @method Style|null findOneBy(array $criteria, array $orderBy = null)
 * @method Style[]    findAll()
 * @method Style[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StyleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Style::class);
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

        $qb = $this->createQueryBuilder('style')
            ->orderBy('style.type', 'ASC');

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
