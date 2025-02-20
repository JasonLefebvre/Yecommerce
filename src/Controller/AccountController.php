<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{

    #[Route('/account', name: 'account')]
    public function account(ArticleRepository $articleRepository, UserRepository $userRepository): Response
    {
        $user = $this->getUser();

        if ($user === null) {
            return $this->redirectToRoute('app_login');
        }

        $articles = $articleRepository->findBy(["auteur_id" => $user->getId()]);
        return $this->render('account.html.twig', ['user' => $user,  'articles' => $articles]);
    }

    #[Route('/account/{id}', name: 'accountPerId')]
    public function userPerId(ArticleRepository $articleRepository, UserRepository $userRepository, int $id): Response
    {
        $user = $userRepository->find($id);

        if ($user === $this->getUser()) {
            // TODO: possibilité d'edit
        }

        if ($user === null) {
            return $this->redirectToRoute('app_login');
        }

        $articles = $articleRepository->findBy(["auteur_id" => $id]);
        return $this->render('account.html.twig', ['user' => $user,  'articles' => $articles]);
    }
}

