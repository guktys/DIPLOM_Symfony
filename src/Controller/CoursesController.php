<?php

namespace App\Controller;

use App\Service\Courses\CoursesAppointmentHandler;
use App\Service\Courses\CoursesAppointmentSaveHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class CoursesController extends AbstractController
{
    #[Route('/courses', name: 'courses')]
    public function courses(): Response
    {
        return $this->render('courses.html.twig', [
        ]);
    }

    #[Route('/courses_appointment', name: 'courses_appointment')]
    public function coursesAppointment(Request $request, CoursesAppointmentHandler $handler): Response
    {
        $context = $handler($request);
        return $this->render('courses_appointment.html.twig', $context);
    }

    #[Route('/courses_appointment_save', name: 'courses_appointment_save')]
    public function coursesAppointmentSave(Request $request, CoursesAppointmentSaveHandler $handler): JsonResponse
    {
        $user = $this->getUser();
        return $handler($request, $user);
    }
}