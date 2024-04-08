<?php

namespace App\Controller\Security;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class NewPassController extends AbstractController
{
    #[Route('/new_user_pass', name: 'new_user_pass')]
    public function index(UserPasswordHasherInterface $passwordHasher, Request $request, EntityManagerInterface $entityManager)
    {
        $user = $this->getUser();
        $userOldPass = $request->request->get('oldPass');
        $userNewPass = $request->request->get('newPass');

        if ($passwordHasher->isPasswordValid($user, $userOldPass)) {
            $newHashedPassword = $passwordHasher->hashPassword($user, $userNewPass);
            $user->setPassword($newHashedPassword);
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->json(['message' => 'Password changed successfully'], 200);
        } else {
            return $this->json(['message' => 'Old password entered incorrectly'], 400);
        }

    }

}