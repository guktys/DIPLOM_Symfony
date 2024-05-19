<?php
declare(strict_types=1);

namespace App\Service;

use App\Repository\ServicesRepository;
use App\Repository\UserRepository;

class HomeHandler
{
    private UserRepository $userRepository;
    private ServicesRepository $servicesRepository;

    public function __construct(UserRepository $userRepository, ServicesRepository $servicesRepository)
    {
        $this->userRepository = $userRepository;
        $this->servicesRepository = $servicesRepository;
    }

    public function __invoke(): array
    {
        $masters = $this->userRepository->findByRole('ROLE_MASTER');
        $services = $this->servicesRepository->findServicesByNumber(5);
        return [
            'masters' => $masters,
            'services' => $services,
        ];

    }
}