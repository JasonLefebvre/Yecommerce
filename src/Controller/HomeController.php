<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    public function index(): Response
    {
        $test = "chose";
        $test2 = "bidute";
        return $this->render('index.html.twig', ["test" => $test, "test2"=> $test2]);
    }
}