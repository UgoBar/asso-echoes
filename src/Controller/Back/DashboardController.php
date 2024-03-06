<?php

namespace App\Controller\Back;

use App\Controller\BaseController;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends BaseController
{
    #[Route('/admin', name: 'back_dashboard')]
    public function index(Request $request): Response
    {
        return $this->render('back/dashboard.html.twig', [
            'nav' => 'dashboard',
            'title' => 'Dashboard'
        ]);
    }
}
