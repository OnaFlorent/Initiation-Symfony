<?php

namespace App\Controller;

use App\Form\EditProfileFormType;
use App\Form\EditPasswordFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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
            return $this->redirectToRoute('profile_index');
        }

        return $this->render('profile/edit_profile.html.twig', [
            'editProfileFormType' => $form->createView()
        ]);
    }

    #[Route(path: '/modifiermdp', name: 'edit_password')]
    public function editPassword(Request $request, EntityManagerInterface $emi, UserPasswordHasherInterface $passwordHasher)
    {
        $user =$this->getUser();
        $form = $this->createForm(EditPasswordFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $emi->persist($user);
            $emi->flush();

            $this->addFlash('success', 'Mot de passe mis à jour avec succès');
            return $this->redirectToRoute('profile_index');
        }

        return $this->render('profile/edit_password.html.twig', [
            'editPasswordFormType' => $form->createView()
        ]);
    }
    
}