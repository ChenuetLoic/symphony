<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Form\ProgramType;
use App\Service\Slugify;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
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
     * @param Slugify $slugify
     * @param MailerInterface $mailer
     * @return Response
     * @throws TransportExceptionInterface
     */
    public function new(Request $request, Slugify $slugify, MailerInterface  $mailer) : Response
    {
        $program = new Program();
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $slug = $slugify->generate($program->getTitle());
            $program->setSlug($slug);
            $entityManager->persist($program);
            $entityManager->flush();

            $email = (new Email())
                ->from($this->getParameter('mailer_from'))
                ->to('your_email@example.com')
                ->subject('Une nouvelle série vient d\'être publiée !')
                ->html($this->renderView('program/newProgramEmail.html.twig', ['program' => $program]));
            $mailer->send($email);

            return $this->redirectToRoute('program_index');
        }
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
     * @Route("/{slug}", name="show")
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
     * @Route ("/{program}/seasons/{season}/episode/{episode}", name="showEpisode")
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
