<?php

namespace App\Controller;

use App\Model\ServicesType;
use App\Repository\ServicesRepository;
use App\Repository\UserRepository;
use App\Service\HomeHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{

    #[Route('/', name: 'home')]
    public function index(HomeHandler $handler)
    {
        $context = $handler();
        return $this->render('homepage.html.twig',$context);
    }

}