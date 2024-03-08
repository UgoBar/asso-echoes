<?php

namespace App\Controller\Back;

use App\Controller\BaseController;
use App\Entity\Gallery;
use App\Form\GalleryType;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GalleryController extends BaseController
{
    #[Route('/admin/gallerie', name: 'back_gallery')]
    public function index(Request $request): Response
    {
        $gallery = $this->getRepo(Gallery::class)->findAll();

        return $this->render('back/gallery/list.html.twig', [
            'gallery' => $gallery,
            'nav'     => 'gallery',
            'title'   => 'Gallerie'
        ]);
    }

    /**
     * @throws EntityNotFoundException
     */
    #[Route('/admin/gallerie/ajout', name: 'back_add_gallery')]
    #[Route('/admin/gallerie/edit/{id}', name: 'back_edit_gallery')]
    public function form(Request $request, Gallery $gallery = null): Response
    {

        $isEdit = $gallery !== null;
        list($gallery, $media) = $this->createEntities('Gallery', $gallery, true);

        // Manage form
        $form = $this->createForm(GalleryType::class, $gallery);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $state = $isEdit ? 'modifiée' : 'ajoutée';
            return $this->save($gallery, true, 'back_gallery', 'La photo <b>'. $gallery .'</b> a bien été ' . $state);
        }

        return $this->render('back/gallery/form.html.twig', [
            'gallery'  => $gallery,
            'nav'      => 'gallery',
            'media'    => $media,
            'title'    => $isEdit ? 'Modifier la photo' : 'Ajouter une photo',
            'subtitle' => $isEdit ? $gallery : false,
            'form'     => $form->createView(),
            'editMode' => $isEdit,
        ]);
    }
}
