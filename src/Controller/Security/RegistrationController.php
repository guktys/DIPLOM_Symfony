<?php

namespace App\Controller\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register_page', name: 'register_page')]
    public function index()
    {
        $user = $this->getUser();
        return $this->render('register.html.twig',[
            'isUserLoggedIn' => $user !== null,
        ]);
    }
    #[Route('/register', name: 'register')]
    public function register(UserPasswordHasherInterface $passwordHasher, Request $request, EntityManagerInterface $entityManager)
    {
         $user = new User();
         $user->setEmail($request->get('email'));
         $user->setFirstname($request->get('firstname'));
         $user->setLastname($request->get('lastname'));
         $user->setPhone($request->get('phone'));
         $user->setTelegramUrl('');
         $user->setRoles((array)'ROLE_USER');
         $plaintextPassword = ($request->get('confirm_password'));
         $hashedPassword = $passwordHasher->hashPassword(
             $user,
             $plaintextPassword
         );
         $user->setPassword($hashedPassword);
        $entityManager->persist($user);
        $entityManager->flush();

        if ($user->getId()) {
            return new JsonResponse(['success' => true, 'message' => 'Ви успішно зареєстровані!']);
        } else {
            return new JsonResponse(['success' => false, 'message' => 'Помилка, спробуйте будь ласка знову пізніше']);
        }

    }
}