<?php

namespace App\Controller\Back;

use App\Controller\BaseController;
use App\Entity\Podcast;
use App\Form\PodcastType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PodcastController extends BaseController
{
    #[Route('/admin/podcasts', name: 'back_podcasts')]
    public function index(Request $request): Response
    {
        $podcasts = $this->getRepo(Podcast::class)->findBy([], ['position' => 'ASC']);

        if(isset($_POST['order'])) {
            foreach ($podcasts as $podcast) {
                $podcast->setPosition($_POST['podcast-'.$podcast->getId().'-position']);
                $this->em()->persist($podcast);
            }
            $this->em()->flush();

            $this->addFlash("success", "L'ordre des podcasts a bien été modifié");
            return $this->redirectToRoute('back_podcasts');
        }

        return $this->render('back/podcast/list.html.twig', [
            'podcasts' => $podcasts,
            'nav' => 'podcast',
            'title' => 'Liste des podcasts'
        ]);
    }

    #[Route('/admin/podcast/ajout', name: 'back_add_podcast')]
    #[Route('/admin/podcast/edit/{id}', name: 'back_edit_podcast')]
    public function form(Request $request, Podcast $podcast = null): Response
    {
        // Manage access to this page (max podcast = 3)
        $countPodcasts = count($this->getRepo(Podcast::class)->findBy([], ['position' => 'ASC']));
        if ($podcast === null && $countPodcasts === 3) {
            $this->addFlash("danger", "Le nombre maximal de podcast a été atteint (3)");
            return $this->redirectToRoute('back_podcasts');
        }

        $isEdit = $podcast !== null;
        list($podcast, $media) = $this->createEntities('Podcast', $podcast, true);
        if ($isEdit === false)
            $podcast->setPosition($countPodcasts + 1);

        // Manage form
        $form = $this->createForm(PodcastType::class, $podcast);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            // First record Media
            $media->setImageFile($data->getMedia()->getImageFile());
            $media->setAlt($data->getMedia()->getAlt());
            $this->save($media);
            // Then record Podcast with previously created Media
            $podcast->setMedia($media);

            $state = $isEdit ? 'modifié' : 'ajouté';
            return $this->save($podcast, true, 'back_podcasts', 'Le podcast "'. $podcast .'" a bien été ' . $state);
        }

        return $this->render('back/podcast/form.html.twig', [
            'podcast' => $podcast,
            'nav' => 'podcast',
            'title' => $isEdit ? 'Modifier le podcast' : 'Ajouter un podcast',
            'subtitle' => $isEdit ? $podcast : false,
            'form' => $form->createView(),
            'editMode' => $isEdit,
            'media' => $media,
        ]);
    }
}
