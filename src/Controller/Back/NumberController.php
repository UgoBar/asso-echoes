<?php

namespace App\Controller\Back;

use App\Controller\BaseController;
use App\Entity\Number;
use App\Form\NumberType;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NumberController extends BaseController
{
    #[Route('/admin/chiffres-clefs', name: 'back_numbers')]
    public function index(Request $request): Response
    {
        $numbers = $this->getRepo(Number::class)->findBy([], ['position' => 'ASC']);

        if(isset($_POST['order'])) {
            foreach ($numbers as $number) {
                $number->setPosition($_POST['number-'.$number->getId().'-position']);
                $this->em()->persist($number);
            }
            $this->em()->flush();

            $this->addFlash("success", "L'ordre des chiffres clefs a bien été modifié");
            return $this->redirectToRoute('back_numbers');
        }

        return $this->render('back/number/list.html.twig', [
            'numbers' => $numbers,
            'nav' => 'number',
            'title' => 'Chiffres clefs'
        ]);
    }

    /**
     * @throws EntityNotFoundException
     */
    #[Route('/admin/chiffre-clef/ajout', name: 'back_add_number')]
    #[Route('/admin/chiffre-clef/edit/{id}', name: 'back_edit_number')]
    public function form(Request $request, Number $number = null): Response
    {

        $countNumbers = count($this->getRepo(Number::class)->findAll());

        $isEdit = $number !== null;
        list($number, $media) = $this->createEntities('Number', $number, true);
        if ($isEdit === false)
            $number->setPosition($countNumbers + 1);

        // Manage form
        $form = $this->createForm(NumberType::class, $number);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            // First record Media
            $media->setImageFile($data->getMedia()->getImageFile());
            $media->setAlt($data->getMedia()->getAlt());
            $this->save($media);
            // Then record Number with previously created Media
            $number->setMedia($media);

            $state = $isEdit ? 'modifié' : 'ajouté';
            return $this->save($number, true, 'back_numbers', 'Le chiffre "'. $number .'" a bien été ' . $state);
        }

        return $this->render('back/number/form.html.twig', [
            'number' => $number,
            'nav' => 'number',
            'title' => $isEdit ? 'Modifier le chiffre clef' : 'Ajouter un chiffre clef',
            'subtitle' => $isEdit ? $number : false,
            'form' => $form->createView(),
            'editMode' => $isEdit,
            'media' => $media,
        ]);
    }
}
