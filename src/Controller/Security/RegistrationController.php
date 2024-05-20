<?php

namespace App\Controller\Security;

use App\Entity\User;
use App\Service\Service\RegistrationHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register_page', name: 'register_page')]
    public function index(): Response
    {
        return $this->render('register.html.twig', [
        ]);
    }

    #[Route('/register', name: 'register')]
    public function register(Request $request, RegistrationHandler $handler): JsonResponse
    {
        return $handler($request);

    }
}