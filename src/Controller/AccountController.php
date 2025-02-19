<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    public function account(Request $request, EntityManagerInterface $entityManager): Response
    {
//        $user = $entityManager->getRepository(User::class)->find(1);

        $articles = $entityManager->getRepository(Article::class)->findBy(["auteur" => 1]);
        return $this->render('account.html.twig', ["articles" => $articles]); //["user" => $user]
    }
}