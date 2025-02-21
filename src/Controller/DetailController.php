<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DetailController extends AbstractController
{
    public function show(int $id, EntityManagerInterface $entityManager): Response
    {
        // Récupérer l'article en fonction de l'ID
        $article = $entityManager->getRepository(Article::class)->find($id);

        // Si l'article n'existe pas, on renvoie une erreur 404
        if (!$article) {
            throw $this->createNotFoundException('L\'article avec l\'ID ' . $id . ' n\'existe pas.');
        }
        $user = $entityManager->getRepository(User::class)->find($article->getAuteurId());
        $connectedUser = $this->getUser();

        // Afficher l'article dans une page dédiée
        return $this->render('detail.html.twig', ['article' => $article, 'user' => $user,  'connectedUser' => $connectedUser]);
    }
}