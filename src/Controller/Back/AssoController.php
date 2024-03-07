<?php

namespace App\Controller\Back;

use App\Controller\BaseController;
use App\Entity\Asso;
use App\Entity\Media;
use App\Entity\Podcast;
use App\Entity\User;
use App\Form\AssoType;
use App\Form\PodcastType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AssoController extends BaseController
{
    #[Route('/admin/asso', name: 'back_asso')]
    public function index(Request $request): Response
    {

        if (count($this->getRepo(Asso::class)->findAll()) > 0) {
            /** @var Asso $asso */
            $asso = $this->getRepo(Asso::class)->findAll()[0];
            $media = $asso->getMedia();
        } else {
            $asso = new Asso();
            $media = new Media();
        }

        // Manage form
        $form = $this->createForm(AssoType::class, $asso);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            // First record Media
            $media->setImageFile($data->getMedia()->getImageFile());
            $media->setAlt($data->getMedia()->getAlt());
            $this->save($media);
            // Then record Podcast with previously created Media
            $asso->setMedia($media);
            return $this->save($asso, true, 'back_asso', 'Les infos de la page association ont été mises à jour');
        }

        return $this->render('back/asso/form.html.twig', [
            'asso' => $asso,
            'nav' => 'podcast',
            'title' => 'Page association',
            'media' => $media,
            'form' => $form->createView()
        ]);
    }
}
