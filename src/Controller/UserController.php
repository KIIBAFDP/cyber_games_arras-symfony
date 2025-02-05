<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/user/{id}/add-role-adminergerfgeornufoergeiurjgiuerngeiurnuieregniueigneiurgnueirgiuergiuergoiuerngiuerngoiuengiuergiujergiueiv,iiiu88161651894984g4b8dger8er89f49', name: 'user_add_role_admin')]
    public function addRoleAdmin(int $id, EntityManagerInterface $entityManager): Response
    {
        $user = $entityManager->getRepository(User::class)->find($id);
        if (!$user) {
            throw $this->createNotFoundException('No user found for id ' . $id);
        }

        $roles = $user->getRoles();
        $roles[] = 'ROLE_ADMIN'; // Add the desired role
        $user->setRoles(array_unique($roles));

        $entityManager->flush();

        return new Response('Role added successfully');
    }
}
