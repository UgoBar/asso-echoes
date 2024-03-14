<?php

namespace App\Controller\Front;

use App\Controller\BaseController;
use App\Entity\TeamInfo;
use App\Entity\TeamMember;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeamController extends BaseController
{
    #[Route('/equipe', name: 'front_team')]
    public function index(): Response
    {

        $teamInfo = count($this->getRepo(TeamInfo::class)->findAll()) > 0 ? $this->getRepo(TeamInfo::class)->findAll()[0] : null;
        $teamMembers = $this->getRepo(TeamMember::class)->findBy([], ['position' => 'ASC']);

        return $this->render('front/team.html.twig', [
            'teamInfo' => $teamInfo,
            'teamMembers' => $teamMembers,
        ]);
    }
}
