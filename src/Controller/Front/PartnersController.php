<?php

namespace App\Controller\Front;

use App\Controller\BaseController;
use App\Entity\Partner;
use App\Entity\PartnerGlobal;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PartnersController extends BaseController
{
    #[Route('/partenaires', name: 'front_partners')]
    public function index(): Response
    {
        $partnerGlobal        = $this->getRepo(PartnerGlobal::class)->findAll()[0];
        $financialPartners    = $this->getRepo(Partner::class)->findBy(['type' => Partner::TYPE_FINANCIAL], ['position' => 'ASC']);
        $collaboratorPartners = $this->getRepo(Partner::class)->findBy(['type' => Partner::TYPE_COLLABORATE], ['position' => 'ASC']);

        return $this->render('front/partners.html.twig', [
            'partnerGlobal'        => $partnerGlobal,
            'financialPartners'    => $financialPartners,
            'collaboratorPartners' => $collaboratorPartners,
        ]);
    }
}
