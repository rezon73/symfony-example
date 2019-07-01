<?php

namespace App\Service;

use App\Entity\Film;
use App\Entity\FilmSession;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class FilmService
 *
 * @package App\Service\FilmService
 */
class FilmService
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
     * @param FilmSession[] $filmSessions
     * @return Film|null
     */
    public function getFilmsByFilmSessions(array $filmSessions)
    {
        $films = [];
        foreach($filmSessions as $filmSession) {
            $films[$filmSession->getFilmId()] = true;
        }
        $films = array_keys($films);

        return $this->doctrine
            ->getRepository(Film::class)
            ->findBy([
                'id' => $films,
            ]);
    }
}