<?php

namespace App\Service\Appointment;

use App\Repository\AppointmentRepository;
use App\Repository\AppointmentStatusRepository;
use App\Repository\ServicesRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use DateTime;

class AppointmentUpdateHandler
{
    private UserRepository $userRepository;
    private ServicesRepository $servicesRepository;
    private AppointmentRepository $appointmentRepository;
    private AppointmentStatusRepository $appointmentStatus;
    private EntityManagerInterface $entityManager;

    public function __construct(
        UserRepository              $userRepository,
        ServicesRepository          $servicesRepository,
        AppointmentRepository       $appointmentRepository,
        AppointmentStatusRepository $appointmentStatus,
        EntityManagerInterface      $entityManager
    )
    {
        $this->userRepository = $userRepository;
        $this->servicesRepository = $servicesRepository;
        $this->appointmentRepository = $appointmentRepository;
        $this->appointmentStatus = $appointmentStatus;
        $this->entityManager = $entityManager;
    }

    public function __invoke($request)
    {
        $appointment = $this->appointmentRepository->findOneBy(['id' => $request->get('id')]);
        $service = $this->servicesRepository->findOneBy(['id' => $request->get('service')]);
        $status = $this->appointmentStatus->findOneBy(['id' => $request->get('status')]);
        if ($appointment) {
            $appointment->setPrice($request->get('appointmentPrice'));
            $appointment->setTime(new DateTime($request->get('appointmentTime')));
            $appointment->setStatus($status);
            $appointment->setService($service);
            $this->entityManager->persist($appointment);
            $this->entityManager->flush();
        }
    }
}