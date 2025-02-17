<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SellController extends AbstractController
{
    public function index(): Response
    {
        $test = "chose";
        return $this->render('sell.html.twig', ["test" => $test]);
    }
}