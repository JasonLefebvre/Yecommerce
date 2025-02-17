<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ValidateController extends AbstractController
{
    public function index(): Response
    {
        $test = "chose";
        return $this->render('validate.html.twig', ["test" => $test]);
    }
}