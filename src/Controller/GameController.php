<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\GameType;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    #[Route('/jeu', name: 'game.index')]
    public function index(GameRepository $repository): Response
    {
        $games = $repository->findAll();
        return $this->render('game/index.html.twig', [
            'games' => $games,
        ]);
    }

    #[Route('/jeu/new', name: 'game.new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $game = new Game();
        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($game);
            $entityManager->flush();

            return $this->redirectToRoute('game.index');
        }

        return $this->render('game/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/jeu/{slug}-{id}', name: 'game.show', requirements: ['slug' => '[a-z0-9-]+', 'id' => '\d+'])]
    public function show(string $slug, int $id, GameRepository $repository): Response
    {
        $game = $repository->find($id);
        if ($game->getSlug() !== $slug) {
            return $this->redirectToRoute('game.show', [
                'id' => $game->getId(),
                'slug' => $game->getSlug(),
            ], 301);
        }
        return $this->render('game/show.html.twig', [
            'game' => $game,
        ]);
    }
}