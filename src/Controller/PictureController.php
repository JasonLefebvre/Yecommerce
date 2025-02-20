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
        // Trouver l'article par son ID
        $article = $this->entityManager->getRepository(Article::class)->find($id);

        // Vérifier si l'article existe et s'il a une image
        if (!$article || !$article->getPicture()) {
            throw $this->createNotFoundException('Image non trouvée.');
        }

        // Récupérer le contenu binaire de l'image
        $image = $article->getPicture();

        // Renvoyer la réponse avec les en-têtes appropriés
        return new Response($image, 200, [
            'Content-Type' => 'image/jpeg',  // Adaptez le type MIME selon votre image
            'Content-Length' => strlen($image),
        ]);
    }
}
