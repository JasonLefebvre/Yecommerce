<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\User;
use App\Form\ArticleType;
use App\Service\SellService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class SellController extends AbstractController
{
    private SellService $sellService;

    public function __construct(SellService $sellService)
    {
        $this->sellService = $sellService;
    }

    #[Route('/sell', name: 'app_sell')]


    public function sell(Request $request): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        $user = null;

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer l'utilisateur connecté
            $user = $this->getUser();

            // Assigner l'ID de l'utilisateur à l'article
            if ($user) {
                $article->setAuteurId($user->getId());
            }

            // Traitement de l'image
            /** @var UploadedFile $file */
            $file = $form->get('picture')->getData();

            if ($file) {
                // Lire le contenu du fichier et le convertir en binaire
                $article->setPicture($file);
            }

            // Définir la date de publication
            if (!$article->getDatePublication()) {
                $article->setDatePublication();  // Cette méthode définit la date actuelle
            }

            // Persister l'article avec tous les champs traités
            $this->sellService->sell($article);

            // Rediriger après l'enregistrement
            return $this->redirectToRoute('app_sell');
        }

        return $this->render('sell.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}