<?php

namespace App\Controller\Back;

use App\Controller\BaseController;
use App\Entity\Media;
use App\Entity\Press;
use App\Form\PressPdfType;
use App\Form\PressType;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PressController extends BaseController
{
    #[Route('/admin/presse', name: 'back_press')]
    public function index(): Response
    {
        $pressItems = $this->getRepo(Press::class)->findBy([], ['position' => 'ASC']);

        if(isset($_POST['order'])) {
            foreach ($pressItems as $press) {
                $press->setPosition($_POST['press-'.$press->getId().'-position']);
                $this->em()->persist($press);
            }
            $this->em()->flush();

            $this->addFlash("success", "L'ordre des éléments de la revue de presse a bien été modifié");
            return $this->redirectToRoute('back_press');
        }

        return $this->render('back/press/list.html.twig', [
            'pressItems' => $pressItems,
            'nav' => 'press',
            'title' => 'Page Revue de presse'
        ]);
    }

    /**
     * @throws EntityNotFoundException
     */
    #[Route('/admin/presse/ajout', name: 'back_add_press')]
    #[Route('/admin/presse/edit/{id}', name: 'back_edit_press')]
    public function form(Request $request, Press $pressItem = null): Response
    {

        $countPressItems = count($this->getRepo(Press::class)->findBy([], ['position' => 'ASC']));

        $isEdit = $pressItem !== null;
        list($pressItem, $media) = $this->createEntities('Press', $pressItem, true);
        if ($isEdit === false)
            $pressItem->setPosition($countPressItems + 1);

        // Manage form
        $form = $this->createForm(PressType::class, $pressItem);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            // First record Media
            $media->setImageFile($data->getMedia()->getImageFile());
            $media->setAlt($data->getMedia()->getAlt());
            $this->save($media);
            // Then record Press item with previously created Media
            $pressItem->setMedia($media);

            $state = $isEdit ? 'modifié' : 'ajouté';
            return $this->save($pressItem, true, 'back_press', 'L\'item de presse <b>'. $pressItem .'</b> a bien été ' . $state);
        }

        return $this->render('back/press/form.html.twig', [
            'pressItem' => $pressItem,
            'nav' => 'press',
            'title' => $isEdit ? 'Modifier l\'item de presse' : 'Ajouter un item de presse',
            'subtitle' => $isEdit ? $pressItem : false,
            'form' => $form->createView(),
            'editMode' => $isEdit,
            'media' => $media,
        ]);
    }


    #[Route('/admin/presse/pdf/{id}', name: 'back_add_press_pdf')]
    public function pdf(Request $request, Press $press): Response
    {
        $pdf = $press->getPdf() ?? new Media();

        // Manage form
        $form = $this->createForm(PressPdfType::class, $press);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            // First record Media
            $pdf->setImageFile($data->getMedia()->getImageFile());
//            $pdf->setUpdatedAt(new \DateTimeImmutable());
            $pdf->setAlt($data->getMedia()->getAlt());
            $this->save($pdf);
            // Then record Press item with previously created Media
            $press->setPdf($pdf);

            return $this->save($press, true, 'back_press', 'Le fichier PDF a bien été mis à jour');
        }

        return $this->render('back/press/pdf.html.twig', [
            'press' => $press,
            'nav' => 'press',
            'title' => 'Lier un fichier PDF',
            'subtitle' => $press,
            'form' => $form->createView(),
            'pdf' => $pdf,
        ]);
    }
}
