<?php

namespace App\Controller;

use App\Entity\Appointment;
use App\Entity\User;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/appointment_save', name: 'appointment_save')]
    public function save(Request $request, EntityManagerInterface $entityManager)
    {

        $master =$this->userRepository->findOneBy(['id'=>$request->get('master')]);
        $user = $this->userRepository->findOneBy(['id'=>$this->getUser()->getId()]);
        $service = $request->get('service');
        $appointment = new Appointment();
        $appointment->setEmployer($master);
        $appointment->setCreateAt(new DateTime());
        $appointment->setUser($user);
        $appointment->setService($service);
        $appointment->setTime(new DateTime($request->get('time')));
        $appointment->setStatus('WAITING');

        $entityManager->persist($appointment);
        $entityManager->flush();
        if ($appointment->getId()) {
            return new JsonResponse(['success' => true, 'message' => 'Ви успішно записані!']);
        } else {
            return new JsonResponse(['success' => false, 'message' => 'Помилка, спробуйте будь ласка знову пізніше']);
        }
    }
}