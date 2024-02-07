<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AssociationController extends AbstractController
{
    #[Route('/association', name: 'front_association')]
    public function index(): Response
    {
        return $this->render('front/association.html.twig', [
            'controller_name' => 'NewsController',
        ]);
    }
}
