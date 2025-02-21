<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends AbstractController
{
    public function admin(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if ($user === null) {
            return $this->redirectToRoute('app_login');
        }

        $articles = $entityManager->getRepository(Article::class)->findAll();

        if (in_array("ROLE_ADMIN", $user->getRoles())) {
            return $this->render('admin.html.twig', ['user' => $user, 'articles' => $articles]);
        } else {
            return $this->redirectToRoute('home');
        }
    }
}