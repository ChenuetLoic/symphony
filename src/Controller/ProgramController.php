<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/programs", name="program_")
 */

class ProgramController extends AbstractController
{
    /**
     * Correspond à la route /programs/ et au name "program_index"
     * @Route("/", name="index")
     * @return Response A response instance
     */
    public function index(): Response
    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();

        return $this->render('program/index.html.twig', ['programs' => $programs]);
    }

    /**
     * @Route("/programs/{id}", name="show")
     * @param Program $program
     * @return Response
     */

    public function show(Program $program): Response
    {
        return $this->render('program/show.html.twig', ['program'=>$program]);
    }

    /**
     * @Route ("program/{program}/seasons/{season}", name="showSeason")
     * @param Season $season
     * @param Program $program
     * @return Response
     */
    public function showSeason(Season $season, Program $program): Response
    {
        return $this->render("program/season_show.html.twig", [
            'program' => $program,
            'season' => $season,
        ]);
    }

    /**
     * @Route ("/programs/{program}/seasons/{season}/episode/{episode}", name="showEpisode")
     * @param Season $season
     * @param Program $program
     * @param Episode $episode
     * @return Response
     */
    public function showEpisode(Season $season, Program $program, Episode $episode): Response
    {
        return $this->render("program/episode_show.html.twig", [
            'program' => $program,
            'episodes' => $episode,
            'season' => $season,
        ]);
    }

}
