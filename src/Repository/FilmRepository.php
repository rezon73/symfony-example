<?php

namespace App\Repository;

use App\Entity\Film;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class FilmRepository
 * @package App\Repository
 */
class FilmRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Film::class);
    }

    /**
     * @param array $ids
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getQueryBuilderByIds(array $ids)
    {
        $queryBuilder = $this->createQueryBuilder('s');

        return $queryBuilder->andWhere($queryBuilder->expr()->in('s.id', $ids));
    }
}