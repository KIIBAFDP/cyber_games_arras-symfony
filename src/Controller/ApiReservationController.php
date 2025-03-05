<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Reservation;

final class ApiReservationController extends AbstractController
{
    #[Route('/api/reservation', name: 'app_api_reservation')]
    public function index(): Response
    {
        return $this->render('api_reservation/index.html.twig', [
            'controller_name' => 'ApiReservationController',
        ]);
    }

    #[Route('/api/reservation/current', name: 'api_reservation_current', methods: ['GET'])]
    public function current(EntityManagerInterface $em): JsonResponse
    {
        // On suppose que l'utilisateur est authentifié via une session ou un token.
        $user = $this->getUser();
        if (!$user) {
            return new JsonResponse(['error' => 'Not authenticated'], JsonResponse::HTTP_UNAUTHORIZED);
        }
        $reservation = $em->getRepository(Reservation::class)->findOneBy(['user' => $user]);
        if (!$reservation) {
            return new JsonResponse(['reservation' => null], JsonResponse::HTTP_OK);
        }
        $now = new \DateTime();
        $remainingSeconds = $reservation->getEndTime()->getTimestamp() - $now->getTimestamp();

        return new JsonResponse([
            'reservation' => [
                'id' => $reservation->getId(),
                'startTime' => $reservation->getStartTime()->format('c'),
                'endTime' => $reservation->getEndTime()->format('c'),
                'remainingSeconds' => $remainingSeconds
            ]
        ], JsonResponse::HTTP_OK);
    }
}
