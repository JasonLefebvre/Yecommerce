<?php


namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Form\EditType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use app\Service\SellService;

class EditController extends AbstractController
{

    private SellService $sellService;



    #[Route('/edit/{id}', name: 'edit', methods: ['GET', 'POST'])]
    public function editArticle(Request $request, int $id, EntityManagerInterface $entityManager): Response
    {
        $article = $entityManager->getRepository(Article::class)->find($id);
        if (!$article) {
            throw $this->createNotFoundException("L'article avec l'ID $id n'existe pas.");
        }



        $form = $this
            ->createForm(ArticleType::class, $article)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $file */
            $file = $form->get('picture')->getData();

            if ($file) {
                // Lire le contenu du fichier et le convertir en binaire
                $article->setPicture($file);
            }

            $entityManager->flush();
            $this->addFlash('success', "Votre article a bien été changé !");
            return $this->redirectToRoute('home');
        }

        return $this->render('edit.html.twig', ["article" => $article, "form" => $form->createView()]);
    }

    #[Route('/edit/{id}/delete', name: 'delete')]
    function deflComment(Request $request, int $id, EntityManagerInterface $entityManager, )
    {

        $this->sellService->deleteArticle($id);
        return $this->redirectToRoute('home');

    }

}