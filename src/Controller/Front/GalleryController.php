<?php

namespace App\Controller\Front;

use App\Controller\BaseController;
use App\Entity\Gallery;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GalleryController extends BaseController
{
    #[Route('/gallerie', name: 'front_gallery')]
    public function index(): Response
    {
        $pictures = $this->getRepo(Gallery::class)->findAll();

        return $this->render('front/gallery.html.twig', [
            'pictures' => $pictures,
        ]);
    }
}
