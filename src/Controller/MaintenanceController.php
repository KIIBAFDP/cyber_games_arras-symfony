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
    #[Route('/maintenance', name: 'maintenance.index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $maintenances = $entityManager->getRepository(Maintenance::class)->findAll();
        $computers = $entityManager->getRepository(Computer::class)->findAll();

        return $this->render('maintenance/index.html.twig', [
            'maintenances' => $maintenances,
            'computers' => $computers,
        ]);
    }

    #[Route('/maintenance/new', name: 'maintenance.new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $maintenance = new Maintenance();
        $form = $this->createForm(MaintenanceType::class, $maintenance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($maintenance);
            $entityManager->flush();

            $this->addFlash('success', 'Maintenance planifiée avec succès.');

            return $this->redirectToRoute('maintenance.index');
        }

        return $this->render('maintenance/newmaintenance.html.twig', [
            'maintenanceForm' => $form->createView(),
        ]);
    }

    #[Route('/maintenance/{id}/edit', name: 'maintenance.edit')]
    public function edit(Request $request, Computer $computer, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ComputerType::class, $computer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Ordinateur mis à jour avec succès.');

            return $this->redirectToRoute('maintenance.index');
        }

        return $this->render('maintenance/edit.html.twig', [
            'computer' => $computer,
            'computerForm' => $form->createView(),
        ]);
    }

    #[Route('/maintenance/{id}/delete', name: 'maintenance.delete', methods: ['POST'])]
    public function delete(Request $request, Computer $computer, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$computer->getId(), $request->request->get('_token'))) {
            $entityManager->remove($computer);
            $entityManager->flush();

            $this->addFlash('success', 'Ordinateur supprimé avec succès.');
        }

        return $this->redirectToRoute('maintenance.index');
    }

    #[Route('/maintenance/{id}/complete', name: 'maintenance.complete', methods: ['POST'])]
    public function complete(Request $request, Maintenance $maintenance, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('complete'.$maintenance->getId(), $request->request->get('_token'))) {
            $maintenance->setIsCompleted(true);
            $entityManager->flush();

            $this->addFlash('success', 'Maintenance terminée avec succès.');
        }

        return $this->redirectToRoute('maintenance.index');
    }
}
