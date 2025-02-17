<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DetailController extends AbstractController
{
    public function index(): Response
    {
        $test = "chose";
        return $this->render('detail.html.twig', ["test" => $test]);
    }
}