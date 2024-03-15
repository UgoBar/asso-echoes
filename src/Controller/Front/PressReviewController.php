<?php

namespace App\Controller\Front;

use App\Controller\BaseController;
use App\Entity\Press;
use App\Entity\Site;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PressReviewController extends BaseController
{
    #[Route('/revue-presse', name: 'front_press_review')]
    public function index(): Response
    {
        $pressItem1 = $this->getRepo(Press::class)->findOneBy(['position' => 1]);
        $pressItem2 = $this->getRepo(Press::class)->findOneBy(['position' => 2]);
        $pressItem3 = $this->getRepo(Press::class)->findOneBy(['position' => 3]);

        $site = $this->getRepo(Site::class)->findAll()[0];

        return $this->render('front/press_review.html.twig', [
            'pressItem1' => $pressItem1,
            'pressItem2' => $pressItem2,
            'pressItem3' => $pressItem3,
            'pressReview' => $site !== null && $site->getPressReview() ? $site->getPressReview() : null,
        ]);
    }
}
