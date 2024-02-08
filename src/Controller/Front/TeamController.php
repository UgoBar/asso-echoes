<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeamController extends AbstractController
{
    #[Route('/equipe', name: 'front_team')]
    public function index(): Response
    {
        return $this->render('front/team.html.twig', [
            'controller_name' => 'TeamController',
        ]);
    }
}
