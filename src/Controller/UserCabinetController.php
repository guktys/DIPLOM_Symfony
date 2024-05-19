<?php

namespace App\Controller;

use App\Model\ServicesType;
use App\Repository\AppointmentRepository;
use App\Repository\CoursesStudentRepository;
use App\Repository\ServicesRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserCabinetController extends AbstractController
{
    private UserRepository $userRepository;
    private AppointmentRepository $appointmentRepository;
    private ServicesRepository $servicesRepository;
    private $kernel;
    private $em;
    private $coursesStudentRepository;

    public function __construct(UserRepository $userRepository, AppointmentRepository $appointmentRepository, KernelInterface $kernel, EntityManagerInterface $em, CoursesStudentRepository $coursesStudentRepository, ServicesRepository $servicesRepository)
    {
        $this->userRepository = $userRepository;
        $this->appointmentRepository = $appointmentRepository;
        $this->kernel = $kernel;
        $this->em = $em;
        $this->coursesStudentRepository = $coursesStudentRepository;
        $this->servicesRepository = $servicesRepository;
    }

    #[Route('/master_cabinet', name: 'master_cabinet')]
    public function masterCabinet()
    {
        $courses =[];
        $services = [];
        $master = $this->getUser();
        $userAppointments = $this->appointmentRepository->findBy(['employer' => $master]);
        $coursesStudent = $this->coursesStudentRepository->findBy(['user' => $master]);
        foreach ($coursesStudent as $courseStudent) {
            $courses[] = $courseStudent->getKourse();
        }
        $masterDetails = $master->getUserDetails();
        $masterAbilitys = $masterDetails->getAbilitys();
        foreach ($masterAbilitys as $masterAbility) {
            $services = $this->servicesRepository->findBy(['category' => $masterAbility, 'type' => ServicesType::SERVICE]);
        }
        return $this->render('master_cabinet.html.twig', [
            'user' => $master,
            'userAppointments' => $userAppointments,
            'courses' => $courses,
            'services' => $services,
        ]);
    }

    #[Route('/user_cabinet', name: 'user_cabinet')]
    public function userСabinet()
    {
        $courses =[];
        $user = $this->getUser();
        $userAppointments = $this->appointmentRepository->findBy(['user' => $this->getUser()]);
        $coursesStudent = $this->coursesStudentRepository->findBy(['user' => $this->getUser()]);
        foreach ($coursesStudent as $courseStudent) {
            $courses[] = $courseStudent->getKourse();
        }
        return $this->render('user_cabinet.html.twig', [
            'user' => $user,
            'userAppointments' => $userAppointments,
            'courses' => $courses,
        ]);
    }

    #[Route('/user_save_logo', name: 'user_save_logo')]
    public function userSaveLogo(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $file = $request->files->get('file');
        $publicDirectory = $this->getParameter('kernel.project_dir') . '/public/images/user-photo/';
        $user = $this->getUser();

        if (!$file instanceof UploadedFile) {
            return $this->json(['status' => 'error', 'message' => 'No file uploaded.'], Response::HTTP_BAD_REQUEST);
        }

        $fileName = md5(uniqid()) . '.' . $file->guessExtension();

        try {
            $file->move($publicDirectory, $fileName);
            $user->setLogo($fileName);
            $em->persist($user);
            $em->flush();

            return $this->json(['status' => 'success', 'fileName' => $fileName]);
        } catch (FileException $e) {
            return $this->json(['status' => 'error', 'message' => 'File upload failed.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}