<?php

namespace App\Controller\Back;

use App\Controller\BaseController;
use App\Entity\Partner;
use App\Entity\PartnerGlobal;
use App\Form\PartnerGlobalType;
use App\Form\PartnerType;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PartnerController extends BaseController
{
    #[Route('/admin/partenaires', name: 'back_partners')]
    public function index(Request $request): Response
    {
        $partnerGlobal = count($this->getRepo(PartnerGlobal::class)->findAll()) > 0 ? $this->getRepo(PartnerGlobal::class)->findAll()[0] : new PartnerGlobal();

        $financialPartners    = $this->getRepo(Partner::class)->findBy(['type' => Partner::TYPE_FINANCIAL], ['position' => 'ASC']);
        $collaboratorPartners = $this->getRepo(Partner::class)->findBy(['type' => Partner::TYPE_COLLABORATE], ['position' => 'ASC']);

        $form = $this->createForm(PartnerGlobalType::class, $partnerGlobal);
        $form->handleRequest($request);

        // ORDER - for Financial
        if(isset($_POST['financial-order'])) {
            foreach ($financialPartners as $partner) {
                $partner->setPosition($_POST['partner-'.$partner->getId().'-position']);
                $this->em()->persist($partner);
            }
            $this->em()->flush();

            $this->addFlash("success", "L'ordre des <b>partenaires financiers</b> a bien été modifié");
            return $this->redirectToRoute('back_partners');
        }

        // ORDER - for Collaborator
        if(isset($_POST['collaborator-order'])) {
            foreach ($collaboratorPartners as $partner) {
                $partner->setPosition($_POST['partner-'.$partner->getId().'-position']);
                $this->em()->persist($partner);
            }
            $this->em()->flush();

            $this->addFlash("success", "L'ordre des <b>partenaires collaborateurs</b> a bien été modifié");
            return $this->redirectToRoute('back_partners');
        }
        
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->save($partnerGlobal, true, 'back_partners', 'Les informations générales de la page <b>Partenaires</b> ont été mises à jour');
        }

        return $this->render('back/partner/list.html.twig', [
            'financialPartners'    => $financialPartners,
            'collaboratorPartners' => $collaboratorPartners,
            'nav' => 'partner',
            'title' => 'Partenaires',
            'form' => $form->createView()
        ]);
    }

    /**
     * @throws EntityNotFoundException
     */
    #[Route('/admin/partenaire/ajout', name: 'back_add_partner')]
    #[Route('/admin/partenaire/edit/{id}', name: 'back_edit_partner')]
    public function form(Request $request, Partner $partner = null): Response
    {

        $isEdit = $partner !== null;
        list($partner, $media) = $this->createEntities('Partner', $partner, true);

        // Manage form
        $form = $this->createForm(PartnerType::class, $partner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            // First record Media
            $media->setImageFile($data->getMedia()->getImageFile());
            $media->setAlt($data->getMedia()->getAlt());
            $this->save($media);
            // Then record Partner with previously created Media
            $partner->setMedia($media);

            $state = $isEdit ? 'modifié' : 'ajouté';
            return $this->save($partner, true, 'back_partners', 'Le partenaire <b>'. $partner .'</b> a bien été ' . $state);
        }

        return $this->render('back/partner/form.html.twig', [
            'partner' => $partner,
            'nav' => 'partner',
            'title' => $isEdit ? 'Modifier le partenaire' : 'Ajouter un partenaire',
            'subtitle' => $isEdit ? $partner : false,
            'form' => $form->createView(),
            'editMode' => $isEdit,
            'media' => $media,
        ]);
    }

    #[Route('/admin/partners/count', name: 'back_count_partners')]
    public function countPartnerFromType(Request $request): JsonResponse
    {
        // Get the "type" parameter from the URL
        $type = $request->query->get('type');

        // Check if the parameter is present
        if (!$type) {
            throw new BadRequestException('Missing parameter "type"');
        }

        $partnerByType = count($this->getRepo(Partner::class)->findBy(['type' => $type]));

        return new JsonResponse($partnerByType + 1);
    }
}
