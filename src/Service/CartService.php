<?php
namespace App\Service;

use App\Entity\Cart;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class CartService
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly Security $security
    ) {
    }

    public function addToCart(int $articleId, int $userId): void
    {
        $cart = new Cart();
        $cart->setArticleId($articleId);
        $cart->setUserId($userId);
        $this->em->persist($cart);
        $this->em->flush();
    }
    public function removeFromCart(int $articleId, int $userId): void
    {
        // Rechercher le panier correspondant à cet article et utilisateur
        $cart = $this->em->getRepository(Cart::class)
            ->findOneBy(['article_id' => $articleId, 'user_id' => $userId]);

        if ($cart) {
            // Si l'article existe dans le panier, on le supprime
            $this->em->remove($cart);
            $this->em->flush();
        }
    }
}
