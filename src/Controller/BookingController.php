<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Computer;
use App\Form\BookingType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class BookingController extends AbstractController
{
    #[Route('/booking/new/{id}', name: 'booking.new')]
    public function new(Request $request, Computer $computer, EntityManagerInterface $entityManager): Response
    {
        // Vérifier que l'ordinateur est disponible
        if (!$computer->isAvailable()) {
            $this->addFlash('error', 'Cet ordinateur n\'est pas disponible pour réservation.');
            return $this->redirectToRoute('booking.index');
        }

        // Exemple d'options forfait; à personnaliser selon les besoins
        $forfaitOptions = [
            'Forfait basique' => 'basic',
            'Forfait standard' => 'standard',
            'Forfait premium' => 'premium'
        ];

        $booking = new Booking();
        $booking->setUser($this->getUser());
        $booking->setComputer($computer);

        // On peut passer les forfaits disponibles au formulaire comme option
        $form = $this->createForm(BookingType::class, $booking, [
            'forfait_options' => $forfaitOptions
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($booking);
            $entityManager->flush();

            $this->addFlash('success', 'Réservation effectuée avec succès.');

            return $this->redirectToRoute('booking.index');
        }

        return $this->render('booking/new.html.twig', [
            'bookingForm' => $form->createView(),
            'computer' => $computer
        ]);
    }

    #[Route('/booking', name: 'booking.index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $bookings = $entityManager->getRepository(Booking::class)->findAll();

        return $this->render('booking/index.html.twig', [
            'bookings' => $bookings,
        ]);
    }

    #[Route('/booking/select', name: 'booking.select')]
    public function select(EntityManagerInterface $entityManager): Response
    {
        $computers = $entityManager->getRepository(Computer::class)->findAll();

        return $this->render('booking/select.html.twig', [
            'computers' => $computers,
        ]);
    }
}
