<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class LoginController extends AbstractController
{
    public function login(Request $request, EntityManagerInterface $entityManager): Response {

        $email = $request->get('email');
        $password = $request->get('password');

        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
        if (!$user || !password_verify($password, $user->getPassword())) {
            return $this->render('login.html.twig', ["erreur", "Email ou mot de passe invalide"]);
        }
        return $this->redirectToRoute('home');
    }
}