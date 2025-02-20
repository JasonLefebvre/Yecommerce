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
}
