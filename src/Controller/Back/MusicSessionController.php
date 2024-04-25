<?php

namespace App\Controller\Back;

use App\Controller\BaseController;
use App\Entity\Media;
use App\Entity\MusicDetail;
use App\Entity\MusicDetailPicture;
use App\Entity\MusicSession;
use App\Form\MusicDetailPictureType;
use App\Form\MusicDetailType;
use App\Form\MusicSessionType;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MusicSessionController extends BaseController
{
    #[Route('/admin/music/rencontres', name: 'back_music_session')]
    public function index(Request $request): Response
    {
        $details = $this->getRepo(MusicDetail::class)->findBy([], ['position' => 'ASC']);
        $session = $this->getRepo(MusicSession::class)->findAll()[0] ?? new MusicSession();

        if(isset($_POST['order'])) {
            foreach ($details as $detail) {
                $detail->setPosition($_POST['detail-'.$detail->getId().'-position']);
                $this->em()->persist($detail);
            }
            $this->em()->flush();

            $this->addFlash("success", "L'ordre des rencontres a bien été modifié");
            return $this->redirectToRoute('back_music_session');
        }

        // Manage form
        $form = $this->createForm(MusicSessionType::class, $session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->save($session, true, 'back_music_session', 'Les infos de la page <b>Rencontres Musicales</b> ont été mises à jour');
        }

        return $this->render('back/music_session/index.html.twig', [
            'session' => $session,
            'details' => $details,
            'form' => $form,
            'nav' => 'music_session',
            'title' => 'Page Rencontres Musicales'
        ]);
    }

    /**
     * @throws EntityNotFoundException
     */
    #[Route('/admin/music/detail/new', name: 'back_add_music_detail')]
    #[Route('/admin/music/detail/edit/{id}', name: 'back_edit_music_detail')]
    public function form(Request $request, MusicDetail $musicDetail = null): Response
    {

        $session = $this->getRepo(MusicSession::class)->findAll() !== [] ? $this->getRepo(MusicSession::class)->findAll()[0] : false;
        $pictures = [];
        if (!$session) {
            return $this->redirectToRoute('back_music_session');
        }

        $isEdit = $musicDetail !== null;
        if ($isEdit === false) {
            list($musicDetail) = $this->createEntities('MusicDetail', $musicDetail);
            $countDetails = count($this->getRepo(MusicDetail::class)->findAll());
            $musicDetail->setPosition($countDetails + 1);
            $musicDetail->setMusicSession($session);
        } else {
            $pictures = $this->getRepo(MusicDetailPicture::class)->findBy(['musicDetail' => $musicDetail]);
        }

        // Manage form
        $form = $this->createForm(MusicDetailType::class, $musicDetail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $state = $isEdit ? 'modifiée' : 'ajoutée';
            $this->em()->persist($musicDetail);
            $this->em()->flush();
            $this->addFlash("success", 'La rencontre <b>'. $musicDetail .'</b> a bien été ' . $state);
            return $this->redirectToRoute('back_edit_music_detail', ['id' => $musicDetail->getId()]);
        }

        return $this->render('back/music_session/detail.html.twig', [
            'musicDetail' => $musicDetail,
            'nav' => 'music_session',
            'title' => $isEdit ? 'Modifier la rencontre' : 'Ajouter une rencontre',
            'subtitle' => $isEdit ? $musicDetail : false,
            'form' => $form->createView(),
            'isEdit' => $isEdit,
            'pictures' => $pictures
        ]);
    }

    #[Route('/admin/music/detail/{id}/picture/add', name: 'back_add_music_detail_picture')]
    public function picture(Request $request, MusicDetail $musicDetail): Response
    {
        $detailPicture = new MusicDetailPicture();
        $media = new Media();

        $pictures = $this->getRepo(MusicDetailPicture::class)->findBy(['musicDetail' => $musicDetail]);
        $detailPicture->setIsFavorite(count($pictures) === 0);

        // Manage form
        $form = $this->createForm(MusicDetailPictureType::class, $detailPicture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            // Assign manually to MusicDetail
            $detailPicture->setMusicDetail($musicDetail);

            // First record Media
            $media->setImageFile($data->getMedia()->getImageFile());
            $media->setAlt($data->getMedia()->getAlt());
            $this->save($media);
            $detailPicture->setMedia($media);

            $this->em()->persist($detailPicture);
            $this->em()->flush();
            $this->addFlash("success", 'La photo de la rencontre <b>'. $musicDetail . '</b> a bien été ajoutée');
            return $this->redirectToRoute('back_edit_music_detail', ['id' => $musicDetail->getId()]);
        }

        return $this->render('back/music_session/picture.html.twig', [
            'nav' => 'music_session',
            'title' => 'Lier une photo',
            'subtitle' => $musicDetail,
            'form' => $form->createView(),
            'media' => $media,
        ]);
    }

    #[Route('/admin/music/detail/picture/set-favorite', name: 'back_music_detail_picture_set_favorite')]
    public function setFavorite(Request $request) {
        // Deserialize the json content
        $data = json_decode($request->getContent(), true);

        // Check that request has entityId and entityName
        if(!array_key_exists('pictureId', $data) || !array_key_exists('detailId', $data)) {
            return new JsonResponse(['actionResponse' => 'unauthorized'], 400);
        }

        $detail = $this->getRepo(MusicDetail::class)->find($data['detailId']);
        $picture = $this->getRepo(MusicDetailPicture::class)->find($data['pictureId']);

        $oldFav = $this->getRepo(MusicDetailPicture::class)->findOneBy(['musicDetail' => $detail, 'isFavorite' => true]);

        $oldFav->setIsFavorite(false);
        $this->em()->persist($oldFav);
        $picture->setIsFavorite(true);
        $this->em()->persist($picture);

        $this->em()->flush();

        return new JsonResponse(['actionResponse' => 'success'], 200);
    }
}
