<?php

namespace App\Controller;

use App\Entity\Registration;
use App\Entity\Tournament;
use App\Form\RegistrationType;
use App\Form\TournamentType;
use App\Repository\TournamentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class TournamentController extends AbstractController
{
    #[Route('/tournaments', name: 'tournament.index')]
    public function index(TournamentRepository $tournamentRepository): Response
    {
        $tournaments = $tournamentRepository->findAll();
        return $this->render('tournament/index.html.twig', [
            'tournaments' => $tournaments,
        ]);
    }

    #[Route('/tournament/new', name: 'tournament.new')]
    #[IsGranted('ROLE_ADMIN')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tournament = new Tournament();
        $form = $this->createForm(TournamentType::class, $tournament);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tournament);
            $entityManager->flush();

            return $this->redirectToRoute('tournament.index');
        }

        return $this->render('tournament/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/tournament/{id}', name: 'tournament.show')]
    public function show(Tournament $tournament): Response
    {
        return $this->render('tournament/show.html.twig', [
            'tournament' => $tournament,
        ]);
    }

    #[Route('/tournament/{id}/edit', name: 'tournament.edit')]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Request $request, Tournament $tournament, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TournamentType::class, $tournament);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('tournament.index');
        }

        return $this->render('tournament/edit.html.twig', [
            'form' => $form->createView(),
            'tournament' => $tournament,
        ]);
    }

    #[Route('/tournament/{id}/register', name: 'tournament.register')]
    public function register(Tournament $tournament, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException('You must be logged in to register for a tournament.');
        }

        if ($tournament->getRegistrations()->count() >= $tournament->getMaxParticipants()) {
            $this->addFlash('error', 'Le nombre maximum de participants a été atteint.');
            return $this->redirectToRoute('tournament.show', ['id' => $tournament->getId()]);
        }

        $user = $this->getUser();
        $existingRegistration = $entityManager->getRepository(Registration::class)->findOneBy([
            'user' => $user,
            'tournament' => $tournament,
        ]);
        if ($existingRegistration) {
            $this->addFlash('error', 'Vous êtes déjà inscrit à ce tournoi.');
            return $this->redirectToRoute('tournament.show', ['id' => $tournament->getId()]);
        }

        $registration = new Registration();
        $registration->setUser($user);
        $registration->setTournament($tournament);
        $registration->setPseudo($user->getPseudo()); // Assuming getUserIdentifier() is a valid method

        $entityManager->persist($registration);
        $entityManager->flush();

        $this->addFlash('success', 'Vous êtes inscrit au tournoi.');

        return $this->redirectToRoute('tournament.show', ['id' => $tournament->getId()]);
    }

    #[Route('/tournament/{id}/unregister', name: 'tournament.unregister')]
    public function unregister(Tournament $tournament, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException('You must be logged in to unregister from a tournament.');
        }

        $user = $this->getUser();
        $registration = $entityManager->getRepository(Registration::class)->findOneBy([
            'user' => $user,
            'tournament' => $tournament,
        ]);

        if ($registration) {
            $entityManager->remove($registration);
            $entityManager->flush();
            $this->addFlash('success', 'Vous vous êtes désinscrit du tournoi.');
        } else {
            $this->addFlash('error', 'Vous n\'êtes pas inscrit à ce tournoi.');
        }

        return $this->redirectToRoute('tournament.show', ['id' => $tournament->getId()]);
    }

    #[Route('/tournament/{id}/delete', name: 'tournament.delete', methods: ['POST'])]
    public function delete(Tournament $tournament, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $entityManager->remove($tournament);
        $entityManager->flush();

        return $this->redirectToRoute('tournament.index');
    }
}
