<?php

namespace App\Controller\Front;

use App\Controller\BaseController;
use App\Entity\MusicDetail;
use App\Entity\MusicDetailPicture;
use App\Entity\MusicSession;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MusicController extends BaseController
{
    #[Route('/rencontres-musicales', name: 'front_music_session')]
    public function index(): Response
    {
        $music    = count($this->getRepo(MusicSession::class)->findAll()) > 0 ? $this->getRepo(MusicSession::class)->findAll()[0] : null;
        $sessions = $this->getRepo(MusicDetail::class)->findBy([], ['position' => 'ASC']);

        return $this->render('front/music_session.html.twig', [
            'music'    => $music,
            'sessions' => $sessions
        ]);
    }

    #[Route('/rencontre-musicale/{id}', name: 'front_music_session_detail')]
    public function detail(MusicDetail $musicDetail): Response
    {
        $pictures = $this->getRepo(MusicDetailPicture::class)->findBy(['musicDetail' => $musicDetail], ['isFavorite' => 'ASC']);

        return $this->render('front/music_detail.html.twig', [
            'session'  => $musicDetail,
            'pictures' => $pictures
        ]);
    }
}
