<?php

namespace App\Controller;

use App\Entity\Appointment;
use App\Entity\User;
use App\Model\ServicesType;
use App\Repository\ServicesRepository;
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
    private ServicesRepository $servicesRepository;

    public function __construct(UserRepository $userRepository, ServicesRepository $servicesRepository)
    {
        $this->userRepository = $userRepository;
        $this->servicesRepository = $servicesRepository;
    }

    #[Route('/appointment', name: 'appointment')]
    public function index(Request $request)
    {
        $services = [];
        $selectedMaster = null;
        $masters = $this->userRepository->findByRole('ROLE_MASTER');
        $consumableItems = [];
        $masterAbilitys = [];
        if ($request->query->has('master')) {
            $selectedMaster = $this->userRepository->findOneBy(['id' => $request->query->get('master')]);
            $masterDetails = $selectedMaster->getUserDetails();
            $masterAbilitys = $masterDetails->getAbilitys();
            foreach ($masterAbilitys as $masterAbility) {
                $services = $this->servicesRepository->findBy(['category' => $masterAbility, 'type' => ServicesType::SERVICE]);
            }
        } else {
            $services = $this->servicesRepository->findBy(['type' => ServicesType::SERVICE]);
        }
        foreach ($services as $service) {
            $temp = $this->servicesRepository->findBy(['category' => $service->getCategory(), 'type' => ServicesType::CONSUMABLE_ITEM]);
            if($temp){
                $consumableItems[$service->getCategory()] = $temp;
            }
        }
        return $this->render('appointment.html.twig', [
            'masters' => $masters,
            'selectedMaster' => $request->query->get('master'),
            'masterAbilitys' => $services,
            'consumableItems' => $consumableItems,
        ]);
    }

    #[Route('/appointment_save', name: 'appointment_save')]
    public function save(Request $request, EntityManagerInterface $entityManager)
    {

        $master = $this->userRepository->findOneBy(['id' => $request->get('master')]);
        $user = $this->getUser();
        $service = $this->servicesRepository->findOneBy(['id' => $request->get('service')]);
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