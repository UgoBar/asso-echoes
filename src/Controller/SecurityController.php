<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\User\ForgotPassType;
use App\Form\User\ResetPassType;
use DateInterval;
use DateTime;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends BaseController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
//         if ($this->getUser()) {
//             return $this->redirectToRoute('back_dashboard');
//         }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/forgot-pass', name: 'app_forgot_pass')]
    public function forgotPass(Request $request): RedirectResponse|Response
    {
        $form = $this->createForm(ForgotPassType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $userMail = $form->getData()->getEmail();
            /** @var User $userFound */
            $userFound = $this->getRepo(User::class)->findOneBy(['email' => $userMail]);

            if ($userFound === null) {
                return $this->render('security/forgot_pass.html.twig', [
                    'error' => 'Ce mail ne correspond à aucun utilisateur',
                    'form' => $form->createView()
                ]);
            }

            $token = openssl_random_pseudo_bytes(16);
            $hexaToken = bin2hex($token);
            $ttl = new DateTime();
            $ttl->add(new DateInterval('PT30M'));

            // Update user with token and token's TTL
            $userFound->setToken($hexaToken);
            $userFound->setTokenDiesAt($ttl);
            $this->save($userFound);

            // Send mail
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'From: Association Echoes <contact@association-echoes.fr>'."\r\n";
            $headers .= 'Reply-To: '. $userMail."\r\n";
            $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
            $headers .= 'X-Mailer: PHP/' . phpversion();

            $urlResetPass = $this->generateUrl('app_reset_pass', ['token' => $hexaToken]);
            $msg = '<html><body>';
            $msg .= "Pour réinitialiser ton mot de passe cliques sur ce lien (valable 30 minutes) : $urlResetPass";
            $msg .= '</body></html>';
            $msg = wordwrap($msg,70);

            mail($userMail, 'Réinitialisation du mot de passe', $msg, $headers);

            return $this->redirectToRoute('app_security_mail_sent');
        }

        return $this->render('security/forgot_pass.html.twig', [
            'error' => false,
            'form' => $form->createView()
        ]);
    }

    #[Route(path: '/reset-pass/{token}', name: 'app_reset_pass')]
    public function resetPass(string $token, Request $request): Response
    {
        $error = false;
        $form = $this->createForm(ResetPassType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $userFound = $this->em()->getRepository(User::class)->findOneUserByTokenAndMail($token, $data->getEmail());

            if($data->getPassword() === $data->getConfirmPassword() && $userFound !== null) {
                $passwordHash = password_hash($data->getPassword(), PASSWORD_DEFAULT);
                $userFound->setPassword($passwordHash);
                return $this->save($userFound, true, 'app_login', 'Mot de passe mis à jour !');
            }

            $error = $userFound === null ? 'Le token a expiré ou l\'adresse mail ne correspond à aucun utilisateur' : 'Les deux mots de passes ne sont pas les mêmes';
        }

        return $this->render('security/reset_pass.html.twig', [
            'error' => $error,
            'form' => $form->createView()
        ]);
    }

    #[Route(path: '/forgot-pass/mail-sent', name: 'app_security_mail_sent')]
    public function mailSent(): Response
    {
        return $this->render('security/mail_sent.html.twig');
    }
}
