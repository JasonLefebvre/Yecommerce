<?php

namespace App\Controller;

use App\Form\RegisterType;
use App\Service\RegisterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

final class RegisterController extends AbstractController
{
    public function __construct(
        private readonly RegisterService $registerService
    ) {
    }
    #[Route('/register', name: 'app_register')]
    public function register(Request $request): Response
    {
        $form = $this
            ->createForm(RegisterType::class)
            ->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->registerService->register($form->getData());
        }
        return $this->render('register/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
