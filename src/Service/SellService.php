<?php
namespace App\Service;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use App\Repository\ArticleRepository;

class SellService
{
    private ArticleRepository $articleRepository;
    private EntityManagerInterface $em;  // Déclaration correcte de la p
    public function __construct(
        EntityManagerInterface $em,
        Security $security,
        ArticleRepository $articleRepository  // Injection de ArticleRepository
    ) {

        $this->articleRepository = $articleRepository;
        $this->em = $em;  // Initialisation de la propriété $em
    }

    public function sell(Article $article): void
    {

        // Ajouter la date de publication
        $article->setDatePublication();

        // Persister l'article
        $this->em->persist($article);
        $this->em->flush();
    }

    public function deleteArticle(int $articleID): void
    {
        // Vérifiez qu'il existe des articles avec cet ID dans le panier
        $carts = $this->articleRepository->findBy(['article' => $articleID]);

        if (empty($carts)) {
            throw new \Exception("Aucun article trouvé dans le panier avec l'ID donné");
        }

        foreach ($carts as $cart) {
            $this->em->remove($cart); // Supprimer chaque article du panier
        }

        $this->em->flush(); // Appliquer les suppressions
    }
}
