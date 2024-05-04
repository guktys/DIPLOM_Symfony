<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AboutAsController extends AbstractController
{
    #[Route('/about_us', name: 'about_us')]
    public function aboutUs()
    {

        return $this->render('about_us.html.twig',[
        ]);
    }
}