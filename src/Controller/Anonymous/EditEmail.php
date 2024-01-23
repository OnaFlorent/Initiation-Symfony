<?php

namespace App\Controller\Anonymous;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\User\UserInterface;

class EditEmail extends AbstractController
{
    #[Route(path: '/modifieremail', name: 'edit_email')]
    public function editEmail(EntityManagerInterface $entityManager, UserInterface $user)
    {
            // Find the admin user by their username (you may need to adjust this)
            $adminUser = $entityManager->getRepository(Users::class)->findOneBy(['login' => 'Admin']);
    
            if ($adminUser) {
                // Change the email address for the admin user
                $email = 'anonymous@anonymous.fr';
                $adminUser->setEmail($email);
    
                // Persist the changes to the database
                $entityManager->persist($adminUser);
                $entityManager->flush();
    
                $this->addFlash('success', 'Email de l\'admin modifié avec succès.');
            } else {
                $this->addFlash('warning', 'Utilisateur Admin non trouvé.');
            }
    
            return $this->redirectToRoute('main');
        }
    }

