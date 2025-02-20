<?php

namespace App\Controller;

use App\Form\InvoiceType;
use App\Service\InvoiceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ValidateController extends AbstractController
{
    private InvoiceService $invoiceService;
    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }
    public function index(Request $request): Response
    {
        $form = $this
            ->createForm(InvoiceType::class)
            ->handleRequest($request);
        $user = $this->getUser();
        if ($form->isSubmitted() && $form->isValid()) {
            $this->invoiceService->facturer($form->getData(), $user);
        }
        return $this->render('validate.html.twig', [
            'form' => $form->createView()
        ]);
    }
}