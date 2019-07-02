<?php

namespace App\Service;

use App\Entity\FilmSession;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class FilmSessionService
 * @package App\Service
 */
class FilmSessionService
{
    /**
     * @var ManagerRegistry
     */
    protected $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @param \DateTimeInterface $fromDate
     * @param \DateTimeInterface $toDate
     * @param array $filmIds
     * @return FilmSession[]|null
     */
    public function getGroupedFilmSessions(\DateTimeInterface $fromDate, \DateTimeInterface $toDate, array $filmIds)
    {
        /** @var FilmSession[] $filmSessions */
        $filmSessions = $this->doctrine
            ->getRepository(FilmSession::class)
            ->findByDatesAndFilmIds(
                $fromDate,
                $toDate,
                $filmIds
            );

        $groupedFilmSessions = [];

        foreach($filmSessions as $filmSession) {
            if (!isset($groupedFilmSessions[$filmSession->getFilmId()])) {
                $groupedFilmSessions[$filmSession->getFilmId()] = [];
            }

            $groupedFilmSessions[$filmSession->getFilmId()][] = $filmSession;
        }

        return $groupedFilmSessions;
    }
}
