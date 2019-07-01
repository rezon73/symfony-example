<?php

namespace App\Service;

use App\Entity\FilmSession;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class FilmSessionService
 *
 * @package App\Service\FilmSessionService
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
     * @return FilmSession[]|null
     */
    public function getGroupedFilmSessions(\DateTimeInterface $fromDate, \DateTimeInterface $toDate)
    {
        /** @var FilmSession[] $filmSessions */
        $filmSessions = $this->doctrine
            ->getRepository(FilmSession::class)
            ->findByDates(
                $fromDate,
                $toDate
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
