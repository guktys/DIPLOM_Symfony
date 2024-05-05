<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    #[Route('/', name: 'home')]
    public function index()
    {
        $masters = $this->userRepository->findByRole('ROLE_MASTER');
        return $this->render('homepage.html.twig', [
            'masters' => $masters,
        ]);
    }

}