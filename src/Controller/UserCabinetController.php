<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserCabinetController extends AbstractController
{
    #[Route('/master_cabinet', name: 'master_cabinet')]
    public function master_cabinet()
    {

        return $this->render('master_cabinet.html.twig',[
        ]);
    }

    #[Route('/user_cabinet', name: 'user_cabinet')]
    public function user_cabinet()
    {

        return $this->render('user_cabinet.html.twig',[
        ]);
    }
}