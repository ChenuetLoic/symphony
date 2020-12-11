<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Form\ProgramType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Route("/programs", name="program_")
 */

class ProgramController extends AbstractController
{

    /**
     * The controller for the program add form
     *
     * @Route("/new", name="new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request) : Response
    {
        // Create a new Category Object
        $program = new Program();
        // Create the associated Form
        $form = $this->createForm(ProgramType::class, $program);
        // Get data from HTTP request
        $form->handleRequest($request);
        // Was the form submitted ?
        if ($form->isSubmitted() && $form->isValid()) {
            // Deal with the submitted data
            // Get the Entity Manager
            $entityManager = $this->getDoctrine()->getManager();
            // Persist Category Object
            $entityManager->persist($program);
            // Flush the persisted object
            $entityManager->flush();
            // Finally redirect to categories list
            return $this->redirectToRoute('program_index');
        }
        // Render the form
        return $this->render('program/new.html.twig', [
            "form" => $form->createView(),
        ]);
    }

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
