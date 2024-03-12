<?php

namespace App\Controller\Back;

use App\Controller\BaseController;
use App\Entity\TeamInfo;
use App\Entity\TeamMember;
use App\Form\TeamInfoType;
use App\Form\TeamMemberType;
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
            return $this->save($teamInfo, true, 'back_team_info', 'Les infos de la page <b>équipe</b> ont été mises à jour');
        }

        return $this->render('back/team/info.html.twig', [
            'teamInfo' => $teamInfo,
            'nav' => 'team_info',
            'title' => 'Page équipe',
            'subtitle' => 'Infos',
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/team/members', name: 'back_team_members')]
    public function members(Request $request): Response
    {
        $teamMembers = $this->getRepo(TeamMember::class)->findBy([], ['position' => 'ASC']);

        if(isset($_POST['order'])) {
            foreach ($teamMembers as $member) {
                $member->setPosition($_POST['member-'.$member->getId().'-position']);
                $this->em()->persist($member);
            }
            $this->em()->flush();

            $this->addFlash("success", "L'ordre des membres a bien été modifié");
            return $this->redirectToRoute('back_team_members');
        }

        return $this->render('back/team/members.html.twig', [
            'teamMembers' => $teamMembers,
            'nav' => 'team_member',
            'title' => 'Page équipe',
            'subtitle' => 'Membres',
        ]);
    }

    #[Route('/admin/team/members/ajout', name: 'back_add_team_member')]
    #[Route('/admin/team/members/edit/{id}', name: 'back_edit_team_member')]
    public function form(Request $request, TeamMember $member = null): Response
    {

        $countMembers = count($this->getRepo(TeamMember::class)->findAll());

        $isEdit = $member !== null;
        list($member, $media) = $this->createEntities('TeamMember', $member, true);
        if ($isEdit === false)
            $member->setPosition($countMembers + 1);

        // Manage form
        $form = $this->createForm(TeamMemberType::class, $member);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            // First record Media
            $media->setImageFile($data->getMedia()->getImageFile());
            $media->setAlt($data->getMedia()->getAlt());
            $this->save($media);
            // Then record Podcast with previously created Media
            $member->setMedia($media);

            $state = $isEdit ? 'modifié.e' : 'ajouté.e';
            return $this->save($member, true, 'back_team_members', '<b>' . $member->getFullName() .'</b> a bien été ' . $state);
        }

        return $this->render('back/team/member_form.html.twig', [
            'member' => $member,
            'nav' => 'team_member',
            'title' => $isEdit ? 'Modifier un membre' : 'Ajouter un membre',
            'subtitle' => $isEdit ? $member->getFullName() : false,
            'form' => $form->createView(),
            'editMode' => $isEdit,
            'media' => $media,
        ]);
    }
}
