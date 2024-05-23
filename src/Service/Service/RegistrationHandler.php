<?php

namespace App\Service\Service;

use App\Controller\TelegramBotController;
use App\Entity\User;
use App\Entity\UserDetails;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationHandler
{
    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $passwordHasher;
    private TelegramBotController $telegramBotController;

    public function __construct(
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface      $entityManager,
    TelegramBotController $telegramBotController)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
        $this->telegramBotController = $telegramBotController;
    }

    public function __invoke($request): JsonResponse
    {
        $user = new User();
        $userDetails = new UserDetails();
        $user->setEmail($request->get('email'));
        $user->setFirstname($request->get('firstname'));
        $user->setLastname($request->get('lastname'));
        $userDetails->setUser($user);
        $userDetails->setTelegram($request->get('telegram') ?? null);
        $userDetails->setTelegramChatId($request->get('telegramChatId') ?? '');
        $user->setUserDetails($userDetails);
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
        $this->entityManager->persist($userDetails);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        if ($user->getId()) {
            if ($userDetails->getTelegramChatId()) {
                $this->telegramBotController->sendRegisterMessage($user, $userDetails->getTelegramChatId());
            }
            return new JsonResponse(['success' => true, 'message' => 'Ви успішно зареєстровані!']);
        } else {
            return new JsonResponse(['success' => false, 'message' => 'Помилка, спробуйте будь ласка знову пізніше']);
        }
    }
}