<?php

namespace App\Service\Appointment;

use App\Entity\Appointment;
use App\Repository\AppointmentRepository;
use App\Repository\AppointmentStatusRepository;
use App\Repository\ServicesRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use DateTime;

class AppointmentSaveHandler
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

    public function __invoke($request,$user): JsonResponse
    {
        $master = $this->userRepository->findOneBy(['id' => $request->get('master')]);
        $service = $this->servicesRepository->findOneBy(['id' => $request->get('service')]);
        $status = $this->appointmentStatus->findOneBy(['name' => "WAITING"]);
        $appointment = new Appointment();
        $appointment->setEmployer($master);
        $appointment->setCreateAt(new DateTime());
        $appointment->setUser($user);
        $appointment->setService($service);
        $appointment->setPrice($request->get('price'));
        $appointment->setTime(new DateTime($request->get('time')));
        $appointment->setStatus($status);

        $this->entityManager->persist($appointment);
        $this->entityManager->flush();

        if ($appointment->getId()) {
            return new JsonResponse(['success' => true, 'message' => 'Ви успішно записані!']);
        } else {
            return new JsonResponse(['success' => false, 'message' => 'Помилка, спробуйте будь ласка знову пізніше']);
        }
    }
}