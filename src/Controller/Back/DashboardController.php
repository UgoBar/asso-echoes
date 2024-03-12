<?php

namespace App\Controller\Back;

use App\Controller\BaseController;
use App\Entity\LogoBlack;
use App\Entity\LogoWhite;
use App\Entity\Media;
use App\Entity\Site;
use App\Form\LogoBlackType;
use App\Form\LogoWhiteType;
use App\Form\Site\SiteColorType;
use App\Form\Site\SitePressType;
use App\Service\MainColorService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends BaseController
{

    #[Route('/admin', name: 'back_dashboard')]
    public function index(Request $request, MainColorService $colorService): Response
    {
        $logoBlack = count($this->getRepo(LogoBlack::class)->findAll()) > 0 ? $this->getRepo(LogoBlack::class)->findAll()[0] : null;
        $logoWhite = count($this->getRepo(LogoWhite::class)->findAll()) > 0 ? $this->getRepo(LogoWhite::class)->findAll()[0] : null;
        $site      = count($this->getRepo(Site::class)->findAll()) > 0 ? $this->getRepo(Site::class)->findAll()[0] : new Site();
        $color = $colorService->getColor();
        $pressReview = $site->getPressReview() ?? new Media();

        // Manage colorpicker form
        $form = $this->createForm(SiteColorType::class, $site);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->save($site, true, 'back_dashboard', 'La couleur principale a été modifiée');
        }

        // Manager press review form
        $pressForm = $this->createForm(SitePressType::class, $site);
        $pressForm->handleRequest($request);
        if ($pressForm->isSubmitted() && $pressForm->isValid()) {
            $data = $form->getData();
            // First record Media
            $pressReview->setImageFile($data->getPressReview()->getImageFile());
            $pressReview->setAlt($data->getPressReview()->getAlt());
            $this->save($pressReview);
            // Then record Press item with previously created Media
            $site->setPressReview($pressReview);
            return $this->save($site, true, 'back_dashboard', 'La revue de presse : <b>' . $site->getPressReview()->getPicture() . '</b> a bien été mise à jour.');
        }

        return $this->render('back/dashboard.html.twig', [
            'nav' => 'dashboard',
            'title' => 'Dashboard',
            'logoBlack' => $logoBlack,
            'logoWhite' => $logoWhite,
            'form' => $form->createView(),
            'pressForm' => $pressForm->createView(),
            'pressReview' => $pressReview,
            'color' => $color
        ]);
    }

    #[Route('/admin/logo/noir/nouveau', name: 'back_logo_black_new')]
    #[Route('/admin/logo/noir/{id}', name: 'back_logo_black_edit')]
    public function logoBlack(Request $request, LogoBlack $logoBlack = null): \Symfony\Component\HttpFoundation\RedirectResponse|Response
    {
        $isEdit = $logoBlack !== null;
        $state  = $logoBlack !== null ? 'modifié' : 'ajouté';
        list($logoBlack, $media) = $this->createEntities('LogoBlack', $logoBlack, true);

        // Manage form
        $form = $this->createForm(LogoBlackType::class, $logoBlack);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            // First record Media
            $media->setImageFile($data->getMedia()->getImageFile());
            $media->setAlt($data->getMedia()->getAlt());
            $this->save($media);
            // Then record Podcast with previously created Media
            $logoBlack->setMedia($media);

            return $this->save($logoBlack, true, 'back_dashboard', 'Le logo noir a bien été ' . $state);
        }

        return $this->render('back/logo/form.html.twig', [
            'nav' => 'dashboard',
            'title' => 'Logo noir',
            'subtitle' => $isEdit ? 'Modifier' : 'Ajouter',
            'logoBlack' => $logoBlack,
            'form' => $form->createView(),
            'editMode' => $isEdit,
            'media' => $media,
        ]);
    }

    #[Route('/admin/logo/blanc/nouveau', name: 'back_logo_white_new')]
    #[Route('/admin/logo/blanc/{id}', name: 'back_logo_white_edit')]
    public function logoWhite(Request $request, LogoWhite $logo = null): \Symfony\Component\HttpFoundation\RedirectResponse|Response
    {
        $isEdit = $logo !== null;
        $state  = $logo !== null ? 'modifié' : 'ajouté';
        list($logo, $media) = $this->createEntities('LogoWhite', $logo, true);

        // Manage form
        $form = $this->createForm(LogoWhiteType::class, $logo);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            // First record Media
            $media->setImageFile($data->getMedia()->getImageFile());
            $media->setAlt($data->getMedia()->getAlt());
            $this->save($media);
            // Then record Podcast with previously created Media
            $logo->setMedia($media);
            return $this->save($logo, true, 'back_dashboard', 'Le logo blanc a bien été ' . $state);
        }

        return $this->render('back/logo/form.html.twig', [
            'nav' => 'dashboard',
            'title' => 'Logo blanc',
            'subtitle' => $isEdit ? 'Modifier' : 'Ajouter',
            'logo' => $logo,
            'form' => $form->createView(),
            'editMode' => $isEdit,
            'media' => $media,
        ]);
    }
}
