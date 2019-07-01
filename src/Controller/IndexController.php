<?php

namespace App\Controller;

use App\Entity\Film;
use App\Entity\FilmSession;
use App\Entity\FilmSessionFilter;
use App\Form\FilmSessionFilterForm;
use App\Service\FilmSessionService;
use \Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index()
    {
        $form = $this->createForm(FilmSessionFilterForm::class, new FilmSessionFilter(), [
            'action' => '/search',
            'method' => 'POST',
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
    public function search(Request $request, FilmSessionService $filmSessionService)
    {
        $filmSessionFilter = new FilmSessionFilter();
        $form = $this->createForm(FilmSessionFilterForm::class, $filmSessionFilter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (
                $filmSessionFilter->getFromDate()->diff(
                    $filmSessionFilter->getToDate()
                )->invert < 0
            ) {
                return new Response('Дата начала должна быть меньше даты окончания');
            }

            $filmSessions = $filmSessionService->getGroupedFilmSessions(
                $filmSessionFilter->getFromDate(),
                $filmSessionFilter->getToDate()
            );

            $films = $this->getDoctrine()
                ->getRepository(Film::class)
                ->findBy([
                    'id' => array_keys($filmSessions),
                ]);

            if (empty($films) || empty($filmSessions)) {
                return new Response('Ничего не найдено');
            }

            return $this->render('index/filmSessions.html.twig', [
                'films'    => $films,
                'sessions' => $filmSessions,
            ]);
        }

        return new Response('Only POST!');
    }
}