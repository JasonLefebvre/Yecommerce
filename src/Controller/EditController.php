<?php


namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Form\EditType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditController extends AbstractController
{

//    public function show(int $id, EntityManagerInterface $entityManager): Response
//    {
//        // Récupérer l'article en fonction de l'ID
//        $article = $entityManager->getRepository(Article::class)->find($id);
//
//        // Si l'article n'existe pas, on renvoie une erreur 404
//        if (!$article) {
//            throw $this->createNotFoundException('L\'article avec l\'ID ' . $id . ' n\'existe pas.');
//        }
//
//        // Afficher l'article dans une page dédiée
//        return $this->render('detail.html.twig', ['article' => $article]);
//    }

    #[Route('/edit/{id}', name: 'edit', methods: ['GET', 'POST'])]
    public function editArticle(Request $request, int $id, EntityManagerInterface $entityManager): Response
    {
        $article = $entityManager->getRepository(Article::class)->find($id);
        if (!$article) {
            throw $this->createNotFoundException("L'article avec l'ID $id n'existe pas.");
        }

        if ($request->isMethod('POST')) {
            return $this->redirectToRoute('edit', ['id' => $article->getId()]);
        }

        $form = $this
            ->createForm(ArticleType::class, $article)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $article->setNom($form->get('nom')->getData());
            $article->setDescription($form->get('description')->getData());
            $article->setPrix($form->get('prix')->getData());
            $article->setImage($form->get('picture')->getData());

            $entityManager->flush();
            $this->addFlash('success', "Votre article a bien été changé !");
            return $this->redirectToRoute('home');
        }

        return $this->render('edit.html.twig', ["article" => $article, "form" => $form->createView()]);
    }
}