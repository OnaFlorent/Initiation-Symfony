<?php

namespace App\Controller\Anonymous;

use App\Entity\Users;
use App\Service\SendMailService;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HackEmail extends AbstractController
{
    #[Route(path: '/hackemail', name: 'app_hack')]
    public function sendMailHack(SendMailService $mail)
    {

        $context = array('');

        //On envoie un mail
        $mail->send(
            'no-reply@afpa.fr',
            'admin@afpa.fr',
            'Je vous propose un partenariat via le lien suivant ;)',
            'hack_email',
            $context
        );

        $this->addFlash('success', 'Email envoyé avec succès');
        return $this->redirectToRoute('main');
    }
}
