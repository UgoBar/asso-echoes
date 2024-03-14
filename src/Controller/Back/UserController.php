<?php


namespace App\Controller\Back;

use App\Controller\BaseController;
use App\Entity\User;
use App\Form\User\UserPasswordType;
use App\Form\User\UserType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends BaseController
{
    #[Route('/admin/utilisateurs', name: 'back_users')]
    public function users(): Response
    {
        return $this->render('back/user/list.html.twig', [
            'nav' => 'user',
            'title' => 'Utilisateurs',
            'users' => $this->getRepo(User::class)->findAll(),
        ]);
    }

    #[Route('/admin/user/ajout', name: 'back_add_user')]
    public function form(Request $request): Response
    {
        $user = new User();
        $passwordError = false;

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            if($data->getPassword() === $data->getConfirmPassword()) {
                $passwordHash = password_hash($data->getPassword(), PASSWORD_DEFAULT);
                $user->setPassword($passwordHash);
                return $this->save($user, true, 'back_users', 'L\'utilisateur <b>'. $user->getFirstname() .'</b> a bien été ajouté');
            }

            $passwordError = 'Les deux mots de passes ne sont pas les mêmes';
        }

        return $this->render('back/user/form.html.twig', [
            'nav' => 'user',
            'title' => 'Ajout d\'un utilisateur',
            'form' => $form->createView(),
            'error' => $passwordError
        ]);
    }

    #[Route('/admin/user/{id}/update-password', 'update_user_password')]
    public function updatePassword(Request $request, User $user): RedirectResponse|Response
    {
        $passwordError = false;

        $form = $this->createForm(UserPasswordType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            if($data->getPassword() === $data->getConfirmPassword()) {
                $passwordHash = password_hash($data->getPassword(), PASSWORD_DEFAULT);
                $user->setPassword($passwordHash);
                return $this->save($user, true, 'back_users', 'Ton mot de passe a bien été mis à jour');
            }

            $passwordError = 'Les deux mots de passes ne sont pas les mêmes';

        }

        return $this->render('back/user/update_password.html.twig', [
            'nav' => 'user',
            'title' => 'Modifier ton mot de passe',
            'form' => $form->createView(),
            'error' => $passwordError
        ]);
    }
}
