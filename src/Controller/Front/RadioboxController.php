<?php

namespace App\Controller\Front;

use App\Controller\BaseController;
use App\Entity\Radiobox;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RadioboxController extends BaseController
{
    #[Route('/radiobox', name: 'front_radiobox')]
    public function index(): Response
    {
        $radiobox = $this->getRepo(Radiobox::class)->findAll()[0];

        return $this->render('front/radiobox.html.twig', [
            'radiobox' => $radiobox,
        ]);
    }
}
