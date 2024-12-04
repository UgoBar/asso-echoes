<?php

namespace App\Controller\Back;

use App\Controller\BaseController;
use App\Entity\ActivityReport;
use App\Entity\Podcast;
use App\Form\ActivityReportType;
use App\Form\PodcastType;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActivityReportController extends BaseController
{
    #[Route('/admin/rapports', name: 'back_activity_reports')]
    public function index(Request $request): Response
    {
        $activityReports = $this->getRepo(ActivityReport::class)->findBy([], ['year' => 'DESC']);

        return $this->render('back/activity_report/list.html.twig', [
            'activityReports' => $activityReports,
            'nav' => 'report',
            'title' => 'Rapports d\'activités'
        ]);
    }

    /**
     * @throws EntityNotFoundException
     */
    #[Route('/admin/rapport/ajout', name: 'back_add_report')]
    #[Route('/admin/rapport/edit/{id}', name: 'back_edit_report')]
    public function form(Request $request, ActivityReport $activityReport = null): Response
    {
        $isEdit = $activityReport !== null;
        list($activityReport, $media) = $this->createEntities('ActivityReport', $activityReport, true);

        // Manage form
        $form = $this->createForm(ActivityReportType::class, $activityReport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            // First record Media
            $media->setImageFile($data->getMedia()->getImageFile());
            $media->setAlt($data->getMedia()->getAlt());
            $this->save($media);
            // Then record Podcast with previously created Media
            $activityReport->setMedia($media);

            $year = $activityReport->getYear();

            $state = $isEdit ? 'modifié' : 'ajouté';
            return $this->save($activityReport, true, 'back_activity_reports', "Le rapport de l'année <b>". $year .'</b> a bien été ' . $state);
        }

        return $this->render('back/activity_report/form.html.twig', [
            'activityReport' => $activityReport,
            'nav' => 'report',
            'title' => $isEdit ? 'Modifier le rapport d\'activité' : 'Ajouter un rapport d\'activité',
            'subtitle' => $isEdit ? $activityReport : false,
            'form' => $form->createView(),
            'editMode' => $isEdit,
            'media' => $media,
        ]);
    }
}
