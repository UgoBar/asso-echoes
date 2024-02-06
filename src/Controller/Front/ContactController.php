<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Mailjet\Client;
use Mailjet\Resources;

class ContactController extends AbstractController
{

    #[Route('/contact', name: 'front_contact')]
    public function index(Request $request, MailerInterface $mailer, ValidatorInterface $validator): Response
    {
        if ($request->isMethod('POST')) {
            $data = $request->request->all();
            $this->sendEmail($mailer, $validator, $data);
        }

        return $this->render('front/contact.html.twig', [
            'controller_name' => 'NewsController',
        ]);
    }

    #[Route('/add_contact_news', name: 'add_contact_news')]
    public function addContactToNewsletter(Request $request, ValidatorInterface $validator): Response
    {
        $constraints = new Assert\Collection([
            'email' => [
                new Assert\NotBlank(null, 'L\'email doit être renseigné'),
                new Assert\Email(null, 'L\'email n\'est pas valide'),
            ],
        ]);

        // Method should be POST
        if (!$request->isMethod('POST')) {
            $this->addFlash('error', 'Une erreur est survenue');
            return $this->redirectToRoute('front_home');
        }

        // Validate email (server side)
        $email = $request->request->get('newsletter-email');
        $errors = $validator->validate(['email' => $email], $constraints);
        if (count($errors) > 0) {
            foreach ($errors as $error) {
                $this->addFlash('error', $error->getMessage());
            }
            return $this->redirectToRoute('front_home');
        }

        // Add contact to newsletter with Mailjet
        $mj = new Client($this->getParameter('app.mailjet_access_key'), $this->getParameter('app.mailjet_secret_key'), true, ['version' => 'v3.1']);
//        $body = ['ContactAlt' => $email, 'ListID' => 256913];
        $body = ['Email' => $email];

//        $response = $mj->post(Resources::$Listrecipient, ['body' => $body]);
        $response = $mj->post(Resources::$ContactslistManagecontact, ['id' => '256913', 'body' => $body]);

        // Vérifiez la réponse de Mailjet (ajustez selon la documentation Mailjet)
        if ($response->success()) {
            return new JsonResponse(['message' => 'Vous avez bien été ajouté à la newsletter.']);
        } else {
            return new JsonResponse(['message' => 'Erreur lors de l\'inscription à la newsletter.'], 500);
        }
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendEmail(MailerInterface $mailer, ValidatorInterface $validator, array $data): RedirectResponse
    {
        // Validate data
        $constraints = new Assert\Collection([
            'name' => [
                new Assert\NotBlank(null, 'Le nom doit être renseigné'),
            ],
            'email' => [
                new Assert\NotBlank(null, 'L\'email doit être renseigné'),
                new Assert\Email(null, 'L\'email n\'est pas valide'),
            ],
            'subject' => [
                new Assert\NotBlank(null, 'Le sujet doit être renseigné'),
            ],
            'message' => [
                new Assert\NotBlank(),
                new Assert\Regex([
                    'pattern' => '/^[^<>;=#{}%^*()\/]+$/',
                    'message' => 'Le message ne doit pas contenir de caractères spéciaux.',
                ]),
            ],
        ]);

        $errors = $validator->validate($data, $constraints);

        if (count($errors) > 0) {
            foreach ($errors as $error) {
                $this->addFlash('error', $error->getMessage());
            }
            return $this->redirectToRoute('front_contact');
        }

        // Send mail
        $email = (new Email())
            ->from($data['email'])
            ->to('ugo17190@example.com')
            ->subject($data['subject'])
            ->text($data['message']);

        $mailer->send($email);

        // Send mail
        // $mailTo  = 'pfavre92@icloud.com';
//        $mailTo  = 'ugo17190@gmail.com';
//
//        $headers  = 'MIME-Version: 1.0' . "\r\n";
//        $headers .= 'From: Association Echoes <contact@association-echoes.fr>'."\r\n";
//        $headers .= 'Reply-To: '. $data['email']."\r\n";
//        $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
//        $headers .= 'X-Mailer: PHP/' . phpversion();
//
//        mail($mailTo, $data['subject'], $data['message'], $headers);

        $this->addFlash('success', 'Votre email a bien été envoyé');
        return $this->redirectToRoute('front_contact');
    }
}
