<?php

namespace App\Controller;

use App\Form\InvoiceType;
use App\Service\InvoiceService;
use App\Service\CartService;  // Ajoutez cette ligne pour accéder au service de panier
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateController extends AbstractController
{
    private InvoiceService $invoiceService;
    private CartService $cartService;  // Déclarez le service CartService

    public function __construct(InvoiceService $invoiceService, CartService $cartService)
    {
        $this->invoiceService = $invoiceService;
        $this->cartService = $cartService;  // Injectez CartService
    }

    public function index(Request $request): Response
    {
        // Récupérer l'utilisateur actuel
        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException('Utilisateur non authentifié');
        }

        // Calculer le total du panier
        $total = $this->cartService->getCartTotal($user->getId());  // Appel à la méthode pour calculer le total

        // Créer et gérer le formulaire
        $form = $this->createForm(InvoiceType::class)
            ->handleRequest($request);

        // Si le formulaire est soumis et valide, facturer
        if ($form->isSubmitted() && $form->isValid()) {
            // Passer le montant total à la méthode facturer
            $this->invoiceService->facturer($form->getData(), $user, $total);  // Ajoutez le total ici
        }

        return $this->render('validate.html.twig', [
            'form' => $form->createView(),
            'total' => $total  // Affichez le total dans la vue si nécessaire
        ]);
    }
}
