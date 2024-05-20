<?php

namespace App\Service\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationHandler
{
    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $passwordHasher;
    public function __construct(
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface      $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    public function __invoke($request): JsonResponse
    {
        $user = new User();
        $user->setEmail($request->get('email'));
        $user->setFirstname($request->get('firstname'));
        $user->setLastname($request->get('lastname'));
        $user->setPhone($request->get('phone'));
        $user->setUserDetails(null);
        $user->setRoles((array)'ROLE_USER');
        $user->setLogo('logo.png');
        $plaintextPassword = ($request->get('confirm_password'));
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $plaintextPassword
        );
        $user->setPassword($hashedPassword);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        if ($user->getId()) {
            return new JsonResponse(['success' => true, 'message' => 'Ви успішно зареєстровані!']);
        } else {
            return new JsonResponse(['success' => false, 'message' => 'Помилка, спробуйте будь ласка знову пізніше']);
        }
    }
}