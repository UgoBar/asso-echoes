<?php

namespace App\Controller\Back;

use App\Controller\BaseController;
use App\Entity\Contact;
use App\Entity\Media;
use App\Entity\Organize;
use App\Entity\Rent;
use App\Form\Contact\ContactType;
use App\Form\Contact\OrganizeType;
use App\Form\Contact\RentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends BaseController
{
    #[Route('/admin/location', name: 'back_rent')]
    public function rent(Request $request): Response
    {

        if (count($this->getRepo(Rent::class)->findAll()) > 0) {
            /** @var Rent $rent */
            $rent = $this->getRepo(Rent::class)->findAll()[0];
            $media = $rent->getMedia();
        } else {
            $rent = new Rent();
            $media = new Media();
        }

        // Manage form
        $form = $this->createForm(RentType::class, $rent);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            // First record Media
            $media->setImageFile($data->getMedia()->getImageFile());
            $media->setAlt($data->getMedia()->getAlt());
            $this->save($media);
            // Then record Rent with previously created Media
            $rent->setMedia($media);
            return $this->save($rent, true, 'back_rent', 'Les infos de la page <b>location</b> ont été mises à jour');
        }

        return $this->render('back/contact/form.html.twig', [
            'entity' => $rent,
            'nav'    => 'rent',
            'title'  => 'Page Location',
            'media'  => $media,
            'form'   => $form->createView(),
            'uploadLabel'  => 'rent_media_imageFile_file',
        ]);
    }

    #[Route('/admin/orga-atelier', name: 'back_organize')]
    public function organize(Request $request): Response
    {
        if (count($this->getRepo(Organize::class)->findAll()) > 0) {
            /** @var Organize $organize */
            $organize = $this->getRepo(Organize::class)->findAll()[0];
            $media = $organize->getMedia();
        } else {
            $organize = new Organize();
            $media = new Media();
        }

        // Manage form
        $form = $this->createForm(OrganizeType::class, $organize);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            // First record Media
            $media->setImageFile($data->getMedia()->getImageFile());
            $media->setAlt($data->getMedia()->getAlt());
            $this->save($media);
            // Then record Organize with previously created Media
            $organize->setMedia($media);
            return $this->save($organize, true, 'back_organize', "Les infos de la page <b>organisation d'atelier</b> ont été mises à jour");
        }

        return $this->render('back/contact/form.html.twig', [
            'entity' => $organize,
            'nav'    => 'organize',
            'title'  => 'Page Organisation d\'atelier',
            'media'  => $media,
            'form'   => $form->createView(),
            'uploadLabel'  => 'organize_media_imageFile_file',
        ]);
    }

    #[Route('/admin/contact', name: 'back_contact')]
    public function contact(Request $request): Response
    {

        if (count($this->getRepo(Contact::class)->findAll()) > 0) {
            /** @var Contact $contact */
            $contact = $this->getRepo(Contact::class)->findAll()[0];
            $media = $contact->getMedia();
        } else {
            $contact = new Contact();
            $media = new Media();
        }

        // Manage form
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            // First record Media
            $media->setImageFile($data->getMedia()->getImageFile());
            $media->setAlt($data->getMedia()->getAlt());
            $this->save($media);
            // Then record Contact with previously created Media
            $contact->setMedia($media);
            return $this->save($contact, true, 'back_contact', 'Les infos de la page <b>contact</b> ont été mises à jour');
        }

        return $this->render('back/contact/form.html.twig', [
            'entity' => $contact,
            'nav'    => 'contact',
            'title'  => 'Page Contact',
            'media'  => $media,
            'form'   => $form->createView(),
            'uploadLabel'  => 'contact_media_imageFile_file',
        ]);
    }
}
