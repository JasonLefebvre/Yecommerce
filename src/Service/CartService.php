<?php
namespace App\Service;

use App\Entity\Cart;
use App\Repository\CartRepository;  // Ajoutez cette ligne pour CartRepository
use App\Repository\ArticleRepository;  // Ajoutez cette ligne pour ArticleRepository
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class CartService
{
    private CartRepository $cartRepository;
    private ArticleRepository $articleRepository;
//    private EntityManagerInterface $em;

    public function __construct(
//        EntityManagerInterface $em,
        Security $security,
        CartRepository $cartRepository,  // Injection de CartRepository
        ArticleRepository $articleRepository  // Injection de ArticleRepository
    ) {
        $this->cartRepository = $cartRepository;
        $this->articleRepository = $articleRepository;
    }

    public function addToCart(int $articleId, int $userId, EntityManagerInterface $entityManager): void
    {
        $cart = new Cart();
        $cart->setArticleId($articleId);
        $cart->setUserId($userId);
        $entityManager->persist($cart);
        $entityManager->flush();
    }

    public function removeFromCart(int $articleId, int $userId, EntityManagerInterface $entityManager): void
    {
        // Rechercher le panier correspondant à cet article et utilisateur
        $cart = $this->cartRepository->findOneBy(['article_id' => $articleId, 'user_id' => $userId]);

        if ($cart) {
            // Si l'article existe dans le panier, on le supprime
            $entityManager->remove($cart);
            $entityManager>flush();
        }
    }

    public function getCartTotal(int $userId): float
    {
        // Récupérer tous les paniers associés à l'utilisateur
        $carts = $this->cartRepository->findBy(['user_id' => $userId]);

        // Tableau pour stocker les articles avec la quantité
        $cartItems = [];
        $total = 0;

        // Regrouper les articles par article_id et calculer la quantité
        foreach ($carts as $cart) {
            $article = $this->articleRepository->find($cart->getArticleId());

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

                // Ajouter le sous-total pour cet article
                $total += $article->getPrix() * $cartItems[$cart->getArticleId()]['quantity'];
            }
        }

        return $total;
    }

}
