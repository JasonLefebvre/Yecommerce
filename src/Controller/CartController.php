<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CartRepository;
use App\Service\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    private CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    #[Route('/cart/add/{id}', name: 'cart_add', methods: ['POST'])]
    public function add(int $id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager): Response
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
        $this->cartService->addToCart($article->getId(), $user->getId(), $entityManager);

        // Redirection après ajout au panier
        return $this->redirectToRoute('cart_show');
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
        $total = 0;

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

                $total = $this->cartService->getCartTotal($user->getId());
            }
        }

        // Passer les articles avec leur quantité et le total à la vue
        return $this->render('cart.html.twig', [
            'cartItems' => $cartItems,
            'total' => $total,
        ]);
    }



    #[Route('/cart/remove/{id}', name: 'cart_remove', methods: ['POST'])]
    public function remove(int $id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager): Response
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
        $this->cartService->removeFromCart($article->getId(), $user->getId(), $entityManager);

        // Redirection après suppression de l'article
        return $this->redirectToRoute('cart_show');
    }
}


