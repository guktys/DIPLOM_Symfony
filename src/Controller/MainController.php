<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index()
    {
        // Получаем текущего пользователя
        $user = $this->getUser();
        return $this->render('homepage.html.twig',[
            'isUserLoggedIn' => $user !== null,
        ]);
    }

}