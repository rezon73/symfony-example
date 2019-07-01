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
     * @return FilmSession[]|null
     */
    public function findByDates(\DateTimeInterface $fromDate, \DateTimeInterface $toDate)
    {
        $qb = $this->createQueryBuilder('s');
        $qb
            ->andWhere('s.executeDate BETWEEN :from AND :to')
            ->setParameter('from', $fromDate )
            ->setParameter('to', $toDate)
            ->orderBy('s.executeDate')
        ;
        $result = $qb->getQuery()->getResult();

        return $result;
    }
}