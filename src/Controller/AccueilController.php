<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

class AccueilController extends AbstractController
{
    #[Route('/accueil', name: 'app_accueil')]
    public function index(RequestStack $requestStack): Response
    {
        $session = $requestStack->getSession();
        $nbVisites = $session->get('nb_visites', 0) + 1;
        $session->set('nb_visites', $nbVisites);

        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'nbVisites' => $nbVisites,
        ]);
    }

    #[Route('/bonjour/{prenom}', name: 'app_bonjour')]
    public function bonjour(string $prenom): Response
    {
        return new Response("<h1>Bonjour $prenom ! Bienvenue sur Symfony 7.4</h1>");
    }

    #[Route('/profil/{id}', name: 'app_profil', requirements: ['id' => '\d+'], defaults: ['id' => 1])]
    public function profil(int $id): Response
    {
        return new Response("<h1>Profil de l'utilisateur n°$id</h1>");
    }

    #[Route('/send-email', name: 'app_send_email')]
    public function sendEmail(MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->from('hello@example.com')
            ->to('you@example.com')
            ->subject('Nouvel Article !')
            ->text('Un nouvel article a été publié sur le blog.')
            ->html('<p>Un nouvel article a été publié sur le blog.</p>');

        $mailer->send($email);

        return new Response('Email envoyé avec succès !');
    }
}
