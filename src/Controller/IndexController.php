<?php

namespace App\Controller;

use App\Entity\Film;
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

        $filmSessions = $filmSessionService->getGroupedFilmSessions(
            $filmSessionFilter->getFromDate(),
            $filmSessionFilter->getToDate()
        );

        if (empty($filmSessions)) {
            return new Response('Ничего не найдено');
        }

        $films = $paginator->paginate(
            $this->getDoctrine()
                ->getRepository(Film::class)
                ->getQueryBuilderByIds(array_keys($filmSessions)), /* query NOT result */
            $request->query->getInt('page', 1),
            static::FILM_LIMIT
        );

        return $this->render('index/filmSessions.html.twig', [
            'films'    => $films,
            'sessions' => $filmSessions,
        ]);
    }
}