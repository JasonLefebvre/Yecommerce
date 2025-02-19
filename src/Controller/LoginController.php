<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class LoginController extends AbstractController
{
    public function login(Request $request, EntityManagerInterface $entityManager): ?Response {
        return null;
    }
}