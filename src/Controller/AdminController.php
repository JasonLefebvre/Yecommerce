<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends AbstractController
{
    public function admin(): Response
    {
        $user = $this->getUser();

        if ($user === null) {
            return $this->redirectToRoute('app_login');
        }

        if (in_array("ROLE_ADMIN", $user->getRoles())) {
            return $this->render('admin.html.twig', ['user' => $user]);
        } else {
            return $this->redirectToRoute('home');
        }
    }
}