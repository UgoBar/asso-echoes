<?php

namespace App\Controller\Back;

use App\Controller\BaseController;
use App\Entity\Session;
use App\Form\SessionType;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SessionController extends BaseController
{
    #[Route('/admin/atelier', name: 'back_sessions')]
    public function index(Request $request): Response
    {
        $sessions = $this->getRepo(Session::class)->findAll();
        $sessionsByMonth = [];
        foreach ($sessions as $session) {
            $month = $session->getDate()->format('m');
            $frenchMonth = $this->getFrenchMonth()[$month]; // Access the corresponding month name
            $sessionsByMonth[$frenchMonth][] = $session;
        }

        return $this->render('back/session/list.html.twig', [
            'sessions' => $sessions,
            'sessionsByMonth' => $sessionsByMonth,
            'nav' => 'session',
            'title' => 'Ateliers'
        ]);
    }

    /**
     * @throws EntityNotFoundException
     */
    #[Route('/admin/atelier/ajout', name: 'back_add_session')]
    #[Route('/admin/atelier/edit/{id}', name: 'back_edit_session')]
    public function form(Request $request, Session $session = null): Response
    {

        $isEdit = $session !== null;
        list($session) = $this->createEntities('Session', $session);

        // Manage form
        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $state = $isEdit ? 'modifié' : 'ajouté';
            return $this->save($session, true, 'back_sessions', 'L\'atelier <b>'. $session .'</b> a bien été ' . $state);
        }

        return $this->render('back/session/form.html.twig', [
            'session' => $session,
            'nav' => 'session',
            'title' => $isEdit ? 'Modifier l\'atelier' : 'Ajouter un atelier',
            'subtitle' => $isEdit ? $session : false,
            'form' => $form->createView(),
            'editMode' => $isEdit,
        ]);
    }
}
