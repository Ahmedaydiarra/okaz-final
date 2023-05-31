<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
// use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Mime\Email;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="app_contact")
     */
    public function index(Request $request, MailerInterface $mailer): Response
    {
       $form = $this->createForm(ContactType::class);
       $form->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid()) {

        $data = $form->getData();
        // dd($data);
        $nom = $data['nom'];
        $adress = $data['email'];
        $sujet = $data['sujet'];
        $message = $data['message'];

        $email = (new Email())
        ->from($adress)
        ->to('admin@admin.com')
        ->subject('demande de contact')
        ->text('$message');
        $mailer->send($email);


       }

        return $this->renderForm('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'formulaire' => $form
        ]);
    }
}
