<?php
namespace App\Service;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class SellService
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly Security $security
    ) {
    }

    public function sell(Article $article): void
    {

        // Ajouter la date de publication
        $article->setDatePublication();

        // Persister l'article
        $this->em->persist($article);
        $this->em->flush();
    }
}
