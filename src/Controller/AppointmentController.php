<?php

namespace App\Controller;

use App\Service\Appointment\AppointmentHandler;
use App\Service\Appointment\AppointmentSaveHandler;
use App\Service\Appointment\AppointmentUpdateHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppointmentController extends AbstractController
{
    #[Route('/appointment', name: 'appointment')]
    public function index(Request $request, AppointmentHandler $appointmentHandler): Response
    {
        $context = $appointmentHandler($request);
        return $this->render('appointment.html.twig', $context);
    }

    #[Route('/appointment_update', name: 'appointment_update')]
    public function update(Request $request, AppointmentUpdateHandler $appointmentUpdateHandler): Response
    {
        $appointmentUpdateHandler($request);
        $referer = $request->headers->get('referer');
        return $this->redirect($referer);
    }

    #[Route('/appointment_save', name: 'appointment_save')]
    public function save(Request $request, AppointmentSaveHandler $appointmentSaveHandler): JsonResponse
    {
        $user = $this->getUser();
        return $appointmentSaveHandler($request, $user);
    }
}