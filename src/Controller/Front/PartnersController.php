<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PartnersController extends AbstractController
{
    #[Route('/partenaires', name: 'front_partners')]
    public function index(): Response
    {
        return $this->render('front/partners.html.twig', [
            'controller_name' => 'NewsController',
        ]);
    }
}
