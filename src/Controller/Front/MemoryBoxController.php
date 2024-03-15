<?php

namespace App\Controller\Front;

use App\Controller\BaseController;
use App\Entity\Memorybox;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MemoryBoxController extends BaseController
{
    #[Route('/boite-a-souvenir', name: 'front_memory_box')]
    public function index(): Response
    {
        $memorybox = $this->getRepo(Memorybox::class)->findAll()[0];

        return $this->render('front/memory_box.html.twig', [
            'memorybox' => $memorybox,
        ]);
    }
}
