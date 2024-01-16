<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MemoryBoxController extends AbstractController
{
    #[Route('/boite-a-souvenir', name: 'front_memory_box')]
    public function index(): Response
    {
        return $this->render('front/memory_box/memory_box.html.twig', [
            'controller_name' => 'MemoryBoxController',
        ]);
    }
}
