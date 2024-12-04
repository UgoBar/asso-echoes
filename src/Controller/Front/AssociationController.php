<?php

namespace App\Controller\Front;

use App\Controller\BaseController;
use App\Entity\ActivityReport;
use App\Entity\Asso;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AssociationController extends BaseController
{
    #[Route('/association', name: 'front_association')]
    public function index(): Response
    {
        $asso = count($this->getRepo(Asso::class)->findAll()) > 0 ? $this->getRepo(Asso::class)->findAll()[0] : null;
        $activityReports = $this->getRepo(ActivityReport::class)->findBy([], ['year' => 'DESC']);

        return $this->render('front/association.html.twig', [
            'asso' => $asso,
            'activityReports' => $activityReports,
        ]);
    }
}
