<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\PasswordResetRequestFormType;
use App\Form\PasswordResetFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PasswordResetController extends AbstractController
{
    #[Route('/reset-password', name: 'app_forgot_password_request')]
    public function request(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer, TokenGeneratorInterface $tokenGenerator): Response
    {
        // Affiche le formulaire pour saisir son adresse email
        $form = $this->createForm(PasswordResetRequestFormType::class);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $emailInput = $form->get('email')->getData();
            $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $emailInput]);
            
            if ($user) {
                // Générer et stocker le token
                $token = $tokenGenerator->generateToken();
                $user->setResetToken($token);
                $entityManager->flush();
                
                // Envoyer l'email de réinitialisation
                $email = (new TemplatedEmail())
                    ->from('mathieu01mistretta@gmail.com')
                    ->to($user->getEmail())
                    ->subject('Réinitialisation de votre mot de passe')
                    ->htmlTemplate('emails/password_reset.html.twig')
                    ->context(['resetToken' => $token]);
                $mailer->send($email);
                
                $this->addFlash('success', 'Un email de réinitialisation de mot de passe a été envoyé.');
            } else {
                $this->addFlash('error', 'Aucun utilisateur trouvé avec cet email.');
            }
            
            // Redirige vers la page de login après envoi (vous pouvez rediriger vers une page de confirmation si vous préférez)
            return $this->redirectToRoute('app_login');
        }
        
        return $this->render('password_reset/request.html.twig', [
            'requestForm' => $form->createView(),
        ]);
    }

    #[Route('/reset-password/{token}', name: 'app_reset_password')]
    public function reset(Request $request, string $token, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = $entityManager->getRepository(User::class)->findOneBy(['resetToken' => $token]);
        if (!$user) {
            $this->addFlash('error', 'Token invalide.');
            return $this->redirectToRoute('app_forgot_password_request');
        }
        
        $form = $this->createForm(PasswordResetFormType::class);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setResetToken(null);
            $entityManager->flush();
            
            $this->addFlash('success', 'Votre mot de passe a été réinitialisé avec succès.');
            return $this->redirectToRoute('app_login');
        }
        
        return $this->render('password_reset/reset.html.twig', [
            'resetForm' => $form->createView(),
        ]);
    }
}
