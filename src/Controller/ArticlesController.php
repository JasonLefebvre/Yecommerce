<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticlesController extends AbstractController {

    #[Route('/articles', name: 'articles')]
    public function showArticles(EntityManagerInterface $entityManager): ?Response // TODO : enlever le ? pour que ça ne soit plus nullable
    {
        $repository = $entityManager->getRepository(Article::class);
        $articles = $repository->findAll();
        // TODO return un dictionnaire avec tout les articles
        return $this->render('detail.html.twig', ["articles" => implode($articles)]);
    }

}
