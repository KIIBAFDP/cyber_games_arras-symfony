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

class BookingController extends AbstractController
{
    #[Route('/booking/new/{id}', name: 'booking.new')]
    public function new(Request $request, Computer $computer, EntityManagerInterface $entityManager): Response
    {
        $booking = new Booking();
        $booking->setUser($this->getUser());
        $booking->setComputer($computer);

        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($booking);
            $entityManager->flush();

            $this->addFlash('success', 'Réservation effectuée avec succès.');

            return $this->redirectToRoute('booking.index');
        }

        return $this->render('booking/new.html.twig', [
            'bookingForm' => $form->createView(),
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
}
