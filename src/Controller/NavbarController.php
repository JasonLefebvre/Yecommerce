<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use \Symfony\Component\HttpFoundation\Response;

class NavbarController extends AbstractController
{
    public function navbarAction(): Response
    {
        $user = $this->getUser();
        return $this->render('navbar.html.twig', ["user" => $user]);
    }
}