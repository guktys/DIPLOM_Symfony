<?php

namespace App\Controller;

use App\Entity\FormMessages;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormController extends AbstractController
{
    #[Route('/home_form', name: 'home_form')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $formData = $request->request->all();
        $formMessages = new FormMessages();

        if ($user) {
            $formMessages->setUser($user);
            $formMessages->setEmail($user->getEmail());
            $formMessages->setFirstName($user->getFirstname());
            $formMessages->setLastName($user->getLastname());
        } else {
            $formMessages->setUser(null);
            $formMessages->setEmail($request->request->get('email'));
            $formMessages->setFirstName($request->request->get('firstName'));
            $formMessages->setLastName($request->request->get('lastName'));
        }

        $formMessages->setMessage($request->request->get('ask'));
        $formMessages->setCreatedAt(new \DateTime());
        $entityManager->persist($formMessages);
        $entityManager->flush();

        return new Response('', 200);
    }
}