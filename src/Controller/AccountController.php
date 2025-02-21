<?php

namespace App\Controller;

use App\Form\EditAccountType;
use App\Repository\ArticleRepository;
use App\Repository\InvoiceRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{

    #[Route('/account', name: 'account')]
    public function account(ArticleRepository $articleRepository, InvoiceRepository $invoiceRepository, EntityManagerInterface $entityManager, Request $request): Response
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $factures = $invoiceRepository->findBy(['user_id' => $user->getId()]);
        $articles = $articleRepository->findBy(["auteur_id" => $user->getId()]);

        $form = $this
            ->createForm(EditAccountType::class, $user)
            ->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $form->get("password")->getData();
            if ($password) {
                $user->setPassword(password_hash($password, PASSWORD_BCRYPT));
            }
            $entityManager->flush();
            $this->addFlash('success', "Votre profil a bien été changé !");
            return $this->redirectToRoute('account');
        }

        return $this->render('account.html.twig', ['user' => $user, 'articles' => $articles, "factures" => $factures, "form" => $form->createView(), 'id' => null]);
    }

    #[Route('/account/{id}', name: 'accountPerId')]
    public function userPerId(ArticleRepository $articleRepository, UserRepository $userRepository, int $id): Response
    {
        $user = $userRepository->find($id);

        if ($user === $this->getUser()) {
            // TODO: possibilité d'edit
        }


        $articles = $articleRepository->findBy(["auteur_id" => $id]);
        return $this->render('account.html.twig', [
            'user' => $user,
            'articles' => $articles,
            'id' => $id,
        ]);
    }
}




