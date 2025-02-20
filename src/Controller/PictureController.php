<?php
namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

class PictureController extends AbstractController
{
    private $entityManager;

    // Injection de l'EntityManager dans le contrôleur
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getPicture($id): Response
    {
        $article = $this->entityManager->getRepository(Article::class)->find($id);

        if (!$article || !$article->getPicture()) {
            throw $this->createNotFoundException('Image non trouvée.');
        }

        // 🔍 Convertir le BLOB en chaîne binaire
        $image = stream_get_contents($article->getPicture());

        return new Response($image, 200, [
            'Content-Type' => 'image/jpeg',
        ]);
    }


}
