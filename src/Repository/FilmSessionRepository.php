<?php

namespace App\Repository;

use App\Entity\FilmSession;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class FilmSessionRepository
 * @package App\Repository
 */
class FilmSessionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FilmSession::class);
    }

    /**
     * @param \DateTimeInterface $fromDate
     * @param \DateTimeInterface $toDate
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getFilmIdsQueryByDates(\DateTimeInterface $fromDate, \DateTimeInterface $toDate)
    {
        return $this->createQueryBuilder('s')
            ->select(['s.filmId'])
            ->andWhere('s.executeDate BETWEEN :from AND :to')
            ->setParameter('from', $fromDate)
            ->setParameter('to', $toDate)
            ->groupBy('s.filmId');
    }

    /**
     * @param \DateTimeInterface $fromDate
     * @param \DateTimeInterface $toDate
     * @param array $filmIds
     * @return FilmSession[]
     */
    public function findByDatesAndFilmIds(\DateTimeInterface $fromDate, \DateTimeInterface $toDate, array $filmIds)
    {
        $queryBuilder = $this->createQueryBuilder('s');
        $queryBuilder
            ->andWhere('s.executeDate BETWEEN :from AND :to')
            ->andWhere($queryBuilder->expr()->in('s.filmId', $filmIds))
            ->setParameter('from', $fromDate)
            ->setParameter('to', $toDate)
            ->orderBy('s.executeDate');

        return $queryBuilder->getQuery()->getResult();
    }
}