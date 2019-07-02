<?php

namespace App\Controller;

use App\Entity\Film;
use App\Entity\FilmSession;
use App\Entity\FilmSessionFilter;
use App\Form\FilmSessionFilterForm;
use App\Service\FilmSessionService;
use Knp\Component\Pager\PaginatorInterface;
use \Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    private const FILM_LIMIT = 10;

    /**
     * @Route("/")
     * @return Response
     */
    public function index()
    {
        $form = $this->createForm(FilmSessionFilterForm::class, new FilmSessionFilter(), [
            'action' => '/search',
        ]);

        return $this->render('index/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/search")
     * @param Request $request
     * @param FilmSessionService $filmSessionService
     * @return Response
     */
    public function search(Request $request, FilmSessionService $filmSessionService, PaginatorInterface $paginator)
    {
        $filmSessionFilter = new FilmSessionFilter();
        $form = $this->createForm(FilmSessionFilterForm::class, $filmSessionFilter);
        $form->handleRequest($request);

        switch($filmSessionFilter->validate()) {
            case FilmSessionFilter::VALIDATE_ERROR_NULLED_DATES:
                return new Response('Не введен диапазон дат');
            case FilmSessionFilter::VALIDATE_ERROR_INVERTED_DATES:
                return new Response('Дата начала должна быть меньше даты окончания');
        }

        /** @var FilmSession[] $filmIdRows */
        $filmIdRows = $paginator->paginate(
            $this->getDoctrine()
                ->getRepository(FilmSession::class)
                ->getFilmIdsQueryByDates(
                    $filmSessionFilter->getFromDate(),
                    $filmSessionFilter->getToDate()
                ),
            $request->query->getInt('page', 1),
            static::FILM_LIMIT,
            ['distinct' => false, 'wrap-queries' => true]
        );

        $filmIds = [];
        foreach($filmIdRows as $filmIdRow) {
            $filmIds[] = $filmIdRow['filmId'];
        }

        if (empty($filmIds)) {
            return new Response('Ничего не найдено');
        }

        /** @var FilmSession[] $filmSessions */
        $filmSessions = $filmSessionService->getGroupedFilmSessions(
            $filmSessionFilter->getFromDate(),
            $filmSessionFilter->getToDate(),
            $filmIds
        );

        if (empty($filmSessions)) {
            return new Response('Ничего не найдено');
        }

        $films = $this->getDoctrine()
            ->getRepository(Film::class)
            ->findBy(['id' => $filmIds]);

        return $this->render('index/filmSessions.html.twig', [
            'filmIdRows' => $filmIdRows,
            'films'      => $films,
            'sessions'   => $filmSessions,
        ]);
    }
}