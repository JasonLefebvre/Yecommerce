<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    public function index(): Response
    {
        $test = "chose";
        return $this->render('cart.html.twig', ["test" => $test]);
    }
}