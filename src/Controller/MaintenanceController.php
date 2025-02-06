<?php

namespace App\Controller;

use App\Entity\Maintenance;
use App\Entity\Computer;
use App\Form\MaintenanceType;
use App\Form\ComputerType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MaintenanceController extends AbstractController
{
    #[Route('/maintenance/new', name: 'maintenance.new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $computer = new Computer();
        $form = $this->createForm(ComputerType::class, $computer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($computer);
            $entityManager->flush();

            $this->addFlash('success', 'Ordinateur ajouté avec succès.');

            return $this->redirectToRoute('maintenance.index');
        }

        return $this->render('maintenance/new.html.twig', [
            'computer'     => $computer,
            'computerForm' => $form->createView(),
        ]);
    }

    #[Route('/maintenance', name: 'maintenance.index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Seul l'admin peut accéder à cette page
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $maintenances = $entityManager->getRepository(Maintenance::class)->findAll();
        $computers = $entityManager->getRepository(Computer::class)->findAll();

        return $this->render('maintenance/index.html.twig', [
            'maintenances' => $maintenances,
            'computers' => $computers,
        ]);
    }
}
