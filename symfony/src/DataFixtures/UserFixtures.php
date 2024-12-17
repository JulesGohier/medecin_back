<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserFixtures extends Fixture
{
    private $passwordEncoder;

    // Injecter le service d'encodage du mot de passe
    public function __construct(UserPasswordHasherInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager) : void 
    {
        // Créer le premier utilisateur avec le rôle ROLE_ADMIN
        $admin = new User();
        $admin->setUsername('admin')
              ->setEmail('admin@example.com')
              ->setRoles(['ROLE_ADMIN'])
              ->setPassword($this->passwordEncoder->hashPassword($admin, 'password123'));  // Mot de passe 'password123'
        $manager->persist($admin);

        // Créer le deuxième utilisateur avec le rôle ROLE_MEDECIN
        $medecin = new User();
        $medecin->setUsername('medecin')
                ->setEmail('medecin@example.com')
                ->setRoles(['ROLE_MEDECIN'])
                ->setPassword($this->passwordEncoder->hashPassword($medecin, 'password123'));
        $manager->persist($medecin);

        // Créer le troisième utilisateur avec le rôle ROLE_PATIENT
        $patient = new User();
        $patient->setUsername('patient')
                ->setEmail('patient@example.com')
                ->setRoles(['ROLE_PATIENT'])
                ->setPassword($this->passwordEncoder->hashPassword($patient, 'password123'));
        $manager->persist($patient);

        // Enregistrer tous les utilisateurs dans la base de données
        $manager->flush();
    }
}
