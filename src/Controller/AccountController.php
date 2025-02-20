<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\User;
use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccountController extends AbstractController
{
    #[Route('/account/{id}', name: 'account')]
    public function account(ArticleRepository $articleRepository, UserRepository $userRepository, int $id): Response
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