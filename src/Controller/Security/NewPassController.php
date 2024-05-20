<?php

namespace App\Controller\Security;

use App\Service\Service\ChangePasswordHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class NewPassController extends AbstractController
{
    #[Route('/new_user_pass', name: 'new_user_pass')]
    public function index(Request $request, ChangePasswordHandler $changePasswordHandler): JsonResponse
    {
        $user = $this->getUser();
        return $changePasswordHandler($request, $user);

    }

}