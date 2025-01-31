<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RecipeController extends AbstractController
{
    #[Route('/recette', name: 'recipe.index')]
    public function index(Request $request): Response
    {
        return $this->render('recipe/index.html.twig');
    }

    #[Route('/recette/{slug}-{id}', name: 'recipe.show', requirements: ['slug' => '[a-z0-9-]+', 'id' => '\d+'])]
    public function show(Request $request, string $slug, int $id): Response
    {
        return $this->render('recipe/show.html.twig', [
            'slug' => $slug,
            'id' => $id,
        ]);
    }
}
