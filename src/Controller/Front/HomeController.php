<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'front_home')]
    public function index(): Response
    {
        return $this->render('front/home.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }


    #[Route('/not_found', name: 'front_not_found')]
    public function notFound(): Response
    {
        return $this->render('error404.html.twig');
    }
}
