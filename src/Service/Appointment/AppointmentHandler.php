<?php

namespace App\Service\Appointment;

use App\Model\ServicesType;
use App\Repository\AppointmentRepository;
use App\Repository\AppointmentStatusRepository;
use App\Repository\ServicesRepository;
use App\Repository\UserRepository;

class AppointmentHandler
{
    private UserRepository $userRepository;
    private ServicesRepository $servicesRepository;
    private AppointmentRepository $appointmentRepository;
    private AppointmentStatusRepository $appointmentStatus;

    public function __construct(
        UserRepository              $userRepository,
        ServicesRepository          $servicesRepository,
        AppointmentRepository       $appointmentRepository,
        AppointmentStatusRepository $appointmentStatus
    )
    {
        $this->userRepository = $userRepository;
        $this->servicesRepository = $servicesRepository;
        $this->appointmentRepository = $appointmentRepository;
        $this->appointmentStatus = $appointmentStatus;
    }

    public function __invoke($request): array
    {
        $services = [];
        $selectedMaster = null;
        $masters = $this->userRepository->findByRole('ROLE_MASTER');
        $consumableItems = [];
        $masterAbilities = [];
        if ($request->query->has('master')) {
            $selectedMaster = $this->userRepository->findOneBy(['id' => $request->query->get('master')]);
            $masterDetails = $selectedMaster->getUserDetails();
            $masterAbilities = $masterDetails->getAbilitys();
            foreach ($masterAbilities as $masterAbility) {
                $services = $this->servicesRepository->findBy(['category' => $masterAbility, 'type' => ServicesType::SERVICE]);
            }
        } else {
            $services = $this->servicesRepository->findBy(['type' => ServicesType::SERVICE]);
        }
        foreach ($services as $service) {
            $temp = $this->servicesRepository->findBy(['category' => $service->getCategory(), 'type' => ServicesType::CONSUMABLE_ITEM]);
            if ($temp) {
                $consumableItems[$service->getCategory()] = $temp;
            }
        }
        return [
            'masters' => $masters,
            'selectedMaster' => $request->query->get('master'),
            'masterAbilities' => $services,
            'consumableItems' => $consumableItems,
        ];
    }
}