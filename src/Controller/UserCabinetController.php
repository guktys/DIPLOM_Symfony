<?php

namespace App\Controller;

use App\Repository\AppointmentRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserCabinetController extends AbstractController
{
    private UserRepository $userRepository;
    private AppointmentRepository $appointmentRepository;
    public function __construct(UserRepository $userRepository,AppointmentRepository $appointmentRepository)
    {
        $this->userRepository = $userRepository;
        $this->appointmentRepository = $appointmentRepository;
    }
    #[Route('/master_cabinet', name: 'master_cabinet')]
    public function master_cabinet()
    {

        return $this->render('master_cabinet.html.twig',[

        ]);
    }

    #[Route('/user_cabinet', name: 'user_cabinet')]
    public function user_cabinet()
    {
        $user = $this->getUser();
        $userAppointments = $this->appointmentRepository->findBy(['user'=>$this->getUser()]);
        return $this->render('user_cabinet.html.twig',[
            'user' => $user,
            'userAppointments'=>$userAppointments,
        ]);
    }
}