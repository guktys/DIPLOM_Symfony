<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class Courses extends AbstractController
{
    #[Route('/courses', name: 'courses')]
    public function courses()
    {
        return $this->render('courses.html.twig',[
        ]);
    }
}