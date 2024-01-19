<?php

namespace App\Controller;

use App\Form\EditProfileFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route(path: '/profil', name: 'profile_')]
class ProfileController extends AbstractController
{
    #[Route(path: '/', name: 'index')]
    public function index(): Response
    {
        return $this->render('profile/index.html.twig');
    }

    #[Route(path: '/modifierprofil', name: 'edit_profile')]
    public function editProfile(Request $request, EntityManagerInterface $emi)
    {
        $user =$this->getUser();
        $form = $this->createForm(EditProfileFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $emi->persist($user);
            $emi->flush();

            $this->addFlash('success', 'Profil mis à jour avec succès');
            return $this->redirectToRoute('profile_edit_profile');
        }
        
        return $this->render('profile/edit_profile.html.twig', [
            'editProfileFormType' => $form->createView()
        ]);
    }

    
}