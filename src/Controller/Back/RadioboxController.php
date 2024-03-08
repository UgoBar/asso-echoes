<?php

namespace App\Controller\Back;

use App\Controller\BaseController;
use App\Entity\Media;
use App\Entity\Radiobox;
use App\Form\RadioboxBannerType;
use App\Form\RadioboxMobileBannerType;
use App\Form\RadioboxType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RadioboxController extends BaseController
{
    #[Route('/admin/radiobox', name: 'back_radiobox')]
    public function index(Request $request): Response
    {
        if (count($this->getRepo(Radiobox::class)->findAll()) > 0) {
            /** @var Radiobox $radiobox */
            $radiobox = $this->getRepo(Radiobox::class)->findAll()[0];
            $media = $radiobox->getMedia() ?? new Media();
        } else {
            $radiobox = new Radiobox();
            $media = new Media();
        }

        // Manage form
        $form = $this->createForm(RadioboxType::class, $radiobox);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            // First record Media
            $media->setImageFile($data->getMedia()->getImageFile());
            $media->setAlt($data->getMedia()->getAlt());
            $this->save($media);

            // Then record Radiobox with previously created Media
            $radiobox->setMedia($media);
            return $this->save($radiobox, true, 'back_radiobox', 'Les infos de la page radiobox ont été mises à jour');
        }

        return $this->render('back/radiobox/form.html.twig', [
            'radiobox' => $radiobox,
            'nav' => 'radiobox',
            'title' => 'Page radiobox',
            'media' => $media,
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/radiobox/banniere/desktop', name: 'back_radiobox_banner')]
    public function banner(Request $request): Response
    {
        if (count($this->getRepo(Radiobox::class)->findAll()) > 0) {
            /** @var Radiobox $radiobox */
            $radiobox = $this->getRepo(Radiobox::class)->findAll()[0];
            $banner = $radiobox->getBanner() ?? new Media();
        } else {
            $radiobox = new Radiobox();
            $radiobox->setTitle('La Radiobox');
            $banner = new Media();
        }

        // Manage form
        $form = $this->createForm(RadioboxBannerType::class, $radiobox);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            // Then record Banner
            $banner->setImageFile($data->getBanner()->getImageFile());
            $banner->setAlt($data->getBanner()->getAlt());
            $this->save($banner);

            // Then record Radiobox with previously created Banner
            $radiobox->setBanner($banner);

            return $this->save($radiobox, true, 'back_radiobox', 'La version desktop de la bannière de la page <b>radiobox</b> a été mise à jour');
        }

        return $this->render('back/radiobox/banner.html.twig', [
            'radiobox' => $radiobox,
            'nav' => 'radiobox',
            'title' => 'desktop_banner',
            'banner' => $banner,
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/radiobox/banniere/mobile', name: 'back_radiobox_mobile_banner')]
    public function mobileBanner(Request $request): Response
    {
        if (count($this->getRepo(Radiobox::class)->findAll()) > 0) {
            /** @var Radiobox $radiobox */
            $radiobox = $this->getRepo(Radiobox::class)->findAll()[0];
            $mobileBanner = $radiobox->getMobileBanner() ?? new Media();
        } else {
            $radiobox = new Radiobox();
            $radiobox->setTitle('La Radiobox');
            $mobileBanner = new Media();
        }

        // Manage form
        $form = $this->createForm(RadioboxMobileBannerType::class, $radiobox);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            // Then record Mobile Banner
            $mobileBanner->setImageFile($data->getMobileBanner()->getImageFile());
            $mobileBanner->setAlt($data->getBanner()->getAlt());
            $this->save($mobileBanner);

            // Then record Radiobox with previously created Mobile Banner
            $radiobox->setMobileBanner($mobileBanner);

            return $this->save($radiobox, true, 'back_radiobox', 'La version mobile de La bannière mobile de la page radiobox a été mise à jour');
        }

        return $this->render('back/radiobox/banner.html.twig', [
            'radiobox' => $radiobox,
            'nav' => 'radiobox',
            'title' => 'mobile_banner',
            'mobileBanner' => $mobileBanner,
            'form' => $form->createView()
        ]);
    }
}
