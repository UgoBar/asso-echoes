<?php

namespace App\Controller\Back;

use App\Controller\BaseController;
use App\Entity\Asso;
use App\Entity\Media;
use App\Entity\Podcast;
use App\Entity\TeamInfo;
use App\Entity\User;
use App\Form\AssoType;
use App\Form\PodcastType;
use App\Form\TeamInfoType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeamController extends BaseController
{
    #[Route('/admin/team/info', name: 'back_team_info')]
    public function index(Request $request): Response
    {
        $teamInfo = count($this->getRepo(TeamInfo::class)->findAll()) > 0 ? $this->getRepo(TeamInfo::class)->findAll()[0] : new TeamInfo();

        // Manage form
        $form = $this->createForm(TeamInfoType::class, $teamInfo);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            return $this->save($teamInfo, true, 'back_team_info', 'Les infos de la page équipe ont été mises à jour');
        }

        return $this->render('back/team/info.html.twig', [
            'teamInfo' => $teamInfo,
            'nav' => 'team_info',
            'title' => 'Page équipe',
            'subtitle' => 'infos',
            'form' => $form->createView()
        ]);
    }
}
