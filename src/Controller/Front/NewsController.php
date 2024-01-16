<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{
    #[Route('/news', name: 'front_news')]
    public function index(): Response
    {
        return $this->render('front/news.html.twig', [
            'controller_name' => 'NewsController',
        ]);
    }
}
