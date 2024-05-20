<?php

namespace App\Service\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ChangePasswordHandler
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
    public function __invoke($request, $user): JsonResponse
    {
        $userOldPass = $request->request->get('oldPass');
        $userNewPass = $request->request->get('newPass');

        if ($this->passwordHasher->isPasswordValid($user, $userOldPass)) {
            $newHashedPassword = $this->passwordHasher->hashPassword($user, $userNewPass);
            $user->setPassword($newHashedPassword);
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            return new JsonResponse(['message' => 'Password changed successfully'], 200);
        } else {
            return new JsonResponse(['message' => 'Old password entered incorrectly'], 400);
        }
    }
}