<?php

namespace App\Controller;


use App\Repository\ArticleRepository;
use App\Repository\CartRepository;
use App\Service\CartService;
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
    public function add(int $id, ArticleRepository $articleRepository): Response
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

        // Redirection après ajout au panier (ajustez la route selon vos besoins)
        return $this->redirectToRoute('home');
    }

    #[Route('/cart', name: 'cart_show')]
    public function showCart(CartRepository $cartRepository): Response
    {
        // Récupérer l'utilisateur actuel
        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException('Utilisateur non authentifié');
        }

        // Récupérer tous les paniers associés à l'utilisateur
        $carts = $cartRepository->findBy(['user_id' => $user->getId()]);

        // Passer les paniers à la vue pour affichage
        return $this->render('cart/show.html.twig', [
            'carts' => $carts,
        ]);
    }
}
