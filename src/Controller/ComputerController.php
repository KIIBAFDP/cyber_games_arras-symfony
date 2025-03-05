<?php

namespace App\Controller;

use App\Entity\Computer;
use App\Form\ComputerType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ComputerController extends AbstractController
{
    #[Route('/computer/new', name: 'computer.new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $computer = new Computer();
        $form = $this->createForm(ComputerType::class, $computer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($computer);
            $entityManager->flush();

            $this->addFlash('success', 'Ordinateur créé avec succès.');

            return $this->redirectToRoute('maintenance.index');
        }

        return $this->render('maintenance/new.html.twig', [
            'computerForm' => $form->createView(),
        ]);
    }
}
