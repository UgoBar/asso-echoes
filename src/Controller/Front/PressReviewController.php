<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PressReviewController extends AbstractController
{
    #[Route('/revue-presse', name: 'front_press_review')]
    public function index(): Response
    {
        return $this->render('front/press_review.html.twig', [
            'controller_name' => 'NewsController',
        ]);
    }
}
