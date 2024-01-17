<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

;

class UsersFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordEncoder)
    {

    }

    public function load(ObjectManager $manager): void
    {
        $admin = new Users();
        $admin->setLogin('Admin');
        $admin->setLastname('Belot');
        $admin->setFirstname('Florent');
        $admin->setAddress('114 rue de Roubaix');
        $admin->setZipcode('59200');
        $admin->setCity('Tourcoing');
        $admin->setEmail('admin@afpa.fr');
        $admin->setPassword(
            $this->passwordEncoder->hashPassword($admin, 'admin')
        );
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

        $faker = Faker\Factory::create('fr_FR');

        for($usr = 1; $usr <= 5; $usr++)
        {
            $user = new Users();
            $user->setLogin($faker->userName);
            $user->setLastname($faker->lastName);
            $user->setFirstname($faker->firstName);
            $user->setAddress($faker->streetAddress);
            $user->setZipcode(str_replace(' ', '', $faker->postcode));
            $user->setCity($faker->city);
            $user->setEmail($faker->freeEmail);
            $user->setPassword(
                $this->passwordEncoder->hashPassword($user, 'admin')
            );
            $manager->persist($user);

        }

        $manager->flush();
    }
}
