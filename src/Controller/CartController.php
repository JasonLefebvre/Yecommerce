<?php

namespace App\Controller;


use App\Repository\ArticleRepository;
use App\Repository\CartRepository;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class CartController extends AbstractController
{
    private CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    #[Route('/cart/add/{id}', name: 'cart_add', methods: ['POST'])]
    public function add(int $id, ArticleRepository $articleRepository, Request $request): Response
    {
        // Récupérer l'article en fonction de l'ID
        $article = $articleRepository->find($id);
        if (!$article) {
            throw $this->createNotFoundException('Article non trouvé');
        }

        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException('Utilisateur non authentifié');
        }

        // Utiliser l'identifiant de l'article et de l'utilisateur
        $this->cartService->addToCart($article->getId(), $user->getId());
        // Récupérer la dernière page visitée
        $referer = $request->headers->get('referer');

        // Redirection après ajout au panier (ajustez la route selon vos besoins)
        return $this->redirect($referer ?? $this->generateUrl('home'));
    }


    #[Route('/cart', name: 'cart_show')]
    public function showCart(CartRepository $cartRepository, ArticleRepository $articleRepository): Response
    {
        // Récupérer l'utilisateur actuel
        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException('Utilisateur non authentifié');
        }

        // Récupérer tous les paniers associés à l'utilisateur
        $carts = $cartRepository->findBy(['user_id' => $user->getId()]);

        // Tableau pour stocker les articles avec la quantité
        $cartItems = [];

        // Regrouper les articles par article_id et calculer la quantité
        foreach ($carts as $cart) {
            $article = $articleRepository->find($cart->getArticleId());

            if ($article) {
                // Si l'article est déjà dans le tableau, on augmente la quantité
                if (isset($cartItems[$cart->getArticleId()])) {
                    $cartItems[$cart->getArticleId()]['quantity']++;
                } else {
                    // Si l'article n'est pas encore dans le tableau, on l'ajoute avec une quantité de 1
                    $cartItems[$cart->getArticleId()] = [
                        'article' => $article,
                        'quantity' => 1,
                    ];
                }
            }
        }

        // Passer les articles avec leur quantité à la vue
        return $this->render('cart.html.twig', [
            'cartItems' => $cartItems,
        ]);
    }

    #[Route('/cart/remove/{id}', name: 'cart_remove', methods: ['POST'])]
    public function remove(int $id, ArticleRepository $articleRepository): Response
    {
        // Récupérer l'article en fonction de l'ID
        $article = $articleRepository->find($id);
        if (!$article) {
            throw $this->createNotFoundException('Article non trouvé');
        }

        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException('Utilisateur non authentifié');
        }

        // Utiliser l'identifiant de l'article et de l'utilisateur pour supprimer l'article du panier
        $this->cartService->removeFromCart($article->getId(), $user->getId());

        // Redirection après suppression de l'article
        return $this->redirectToRoute('cart_show');
    }
}


