<?php

namespace App\Controller\Front;

use App\Controller\BaseController;
use App\Entity\Number;
use App\Entity\Podcast;
use App\Entity\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends BaseController
{
    #[Route('/', name: 'front_home')]
    public function index(): Response
    {
        $podcast1 = $this->getRepo(Podcast::class)->findOneBy(['position' => 1]);
        $podcast2 = $this->getRepo(Podcast::class)->findOneBy(['position' => 2]);
        $podcast3 = $this->getRepo(Podcast::class)->findOneBy(['position' => 3]);

        $numbers = $this->getRepo(Number::class)->findBy([], ['position' => 'ASC']);

        $sessions = $this->getRepo(Session::class)->findBy([], ['date' => 'ASC']);

        return $this->render('front/home.html.twig', [
            'podcast1' => $podcast1,
            'podcast2' => $podcast2,
            'podcast3' => $podcast3,
            'numbers' => $numbers,
            'sessions' => $sessions,
        ]);
    }


    #[Route('/not_found', name: 'front_not_found')]
    public function notFound(): Response
    {
        return $this->render('error404.html.twig');
    }
}
