<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AppointmentController extends AbstractController
{
    private UserRepository $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    #[Route('/appointment', name: 'appointment')]
    public function index()
    {

        $masters = $this->userRepository->findByRole('ROLE_MASTER');
        $user = $this->getUser();
        return $this->render('appointment.html.twig',[
            'masters' => $masters,
            'isUserLoggedIn' => $user !== null,
        ]);
    }
}