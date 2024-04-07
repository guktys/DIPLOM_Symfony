<?php

namespace App\Controller;

use App\Repository\AppointmentRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    private $kernel;
    private $em;

    public function __construct(UserRepository $userRepository, AppointmentRepository $appointmentRepository, KernelInterface $kernel, EntityManagerInterface $em)
    {
        $this->userRepository = $userRepository;
        $this->appointmentRepository = $appointmentRepository;
        $this->kernel = $kernel;
        $this->em = $em;
    }

    #[Route('/master_cabinet', name: 'master_cabinet')]
    public function masterСabinet()
    {

        return $this->render('master_cabinet.html.twig', [

        ]);
    }

    #[Route('/user_cabinet', name: 'user_cabinet')]
    public function userСabinet()
    {
        $user = $this->getUser();
        $userAppointments = $this->appointmentRepository->findBy(['user' => $this->getUser()]);
        return $this->render('user_cabinet.html.twig', [
            'user' => $user,
            'userAppointments' => $userAppointments,
        ]);
    }

    #[Route('/user_save_logo', name: 'user_save_logo')]
    public function userSaveLogo(Request $request)
    {
        $file = $request->files->get('file');
        $publicDirectory = $this->kernel->getProjectDir() . '/public';
        $user = $this->getUser();
        if ($file instanceof UploadedFile) {
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();

            try {
                $file->move(
                    $publicDirectory . '/images/user-photo/',
                    $fileName
                );
                $user->setLogo($fileName);
                $this->em->persist($user);
                $this->em->flush($user);
            } catch (FileException $e) {
                return new Response('Ошибка при перемещении файла');
            }
            return new Response('Файл успешно загружен');
        }
        return new Response('Файл не был загружен');
    }
}