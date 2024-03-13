<?php

namespace App\Controller\Back;

use App\Controller\BaseController;
use App\Entity\Media;
use App\Entity\Memorybox;
use App\Form\MemoryboxBannerType;
use App\Form\MemoryboxType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MemoryboxController extends BaseController
{
    #[Route('/admin/memorybox', name: 'back_memorybox')]
    public function index(Request $request): Response
    {
        if (count($this->getRepo(Memorybox::class)->findAll()) > 0) {
            /** @var Memorybox $memorybox */
            $memorybox = $this->getRepo(Memorybox::class)->findAll()[0];
            $media = $memorybox->getMedia() ?? new Media();
        } else {
            $memorybox = new Memorybox();
            $media = new Media();
        }

        // Manage form
        $form = $this->createForm(MemoryboxType::class, $memorybox);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            // First record Media
            $media->setImageFile($data->getMedia()->getImageFile());
            $media->setAlt($data->getMedia()->getAlt());
            $this->save($media);
            // Then record Memorybox with previously created Media
            $memorybox->setMedia($media);
            return $this->save($memorybox, true, 'back_memorybox', 'Les infos de la page <b>Boîte à souvenirs</b> ont été mises à jour');
        }

        return $this->render('back/memorybox/form.html.twig', [
            'memorybox' => $memorybox,
            'nav' => 'memorybox',
            'title' => 'Page Boîte à souvenir',
            'media' => $media,
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/memorybox/banniere', name: 'back_memorybox_banner')]
    public function banner(Request $request): Response
    {
        if (count($this->getRepo(Memorybox::class)->findAll()) > 0) {
            /** @var Memorybox $memorybox */
            $memorybox = $this->getRepo(Memorybox::class)->findAll()[0];
            $banner = $memorybox->getBanner() ?? new Media();
        } else {
            $memorybox = new Memorybox();
            $memorybox->setTitle('La Boîte à Souvenirs');
            $banner = new Media();
        }

        // Manage form
        $form = $this->createForm(MemoryboxBannerType::class, $memorybox);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            $banner->setImageFile($data->getBanner()->getImageFile());
            $banner->setAlt($data->getBanner()->getAlt());
            $this->save($banner);
            $memorybox->setBanner($banner);

            return $this->save($memorybox, true, 'back_memorybox', 'La bannière de la page <b>Boîte à Souvenirs</b> a été mise à jour');
        }

        return $this->render('back/memorybox/banner.html.twig', [
            'memorybox' => $memorybox,
            'nav' => 'memorybox',
            'title' => 'memorybox_banner',
            'banner' => $banner,
            'form' => $form->createView()
        ]);
    }
}
