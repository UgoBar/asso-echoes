<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GalleryController extends AbstractController
{
    #[Route('/gallery', name: 'front_gallery')]
    public function index(): Response
    {
        return $this->render('front/gallery.html.twig', [
            'controller_name' => 'NewsController',
        ]);
    }
}
