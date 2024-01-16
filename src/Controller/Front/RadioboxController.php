<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RadioboxController extends AbstractController
{
    #[Route('/radiobox', name: 'front_radiobox')]
    public function index(): Response
    {
        return $this->render('front/radiobox.html.twig', [
            'controller_name' => 'RadioboxController',
        ]);
    }
}
