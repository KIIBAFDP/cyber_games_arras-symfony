<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Computer;
use App\Form\BookingType;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookingController extends AbstractController
{
    #[Route('/booking/new/{id}', name: 'booking.new')]
    public function new(Request $request, Computer $computer, BookingRepository $bookingRepository, EntityManagerInterface $entityManager): Response
    {
        // Vérifier que l'ordinateur est disponible
        if (!$computer->isAvailable()) {
            $this->addFlash('error', 'Cet ordinateur n\'est pas disponible pour réservation.');
            return $this->redirectToRoute('booking.index');
        }

        // Vérifier si l'utilisateur a déjà une réservation active
        $activeBooking = $bookingRepository->findActiveBookingByUser($this->getUser());
        if ($activeBooking) {
            $this->addFlash('error', 'Vous avez déjà une réservation active.');
            return $this->redirectToRoute('booking.index');
        }

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

    #[Route('/booking/select', name: 'booking.select')]
    public function select(EntityManagerInterface $entityManager): Response
    {
        $computers = $entityManager->getRepository(Computer::class)->findAll();

        return $this->render('booking/select.html.twig', [
            'computers' => $computers,
        ]);
    }

    #[Route('/booking/delete/{id}', name: 'booking.delete', methods: ['POST'])]
    public function delete(Request $request, Booking $booking, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$booking->getId(), $request->request->get('_token'))) {
            $entityManager->remove($booking);
            $entityManager->flush();

            $this->addFlash('success', 'Réservation supprimée avec succès.');
        }

        return $this->redirectToRoute('booking.index');
    }
}
