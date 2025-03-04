<?php

namespace App\DataFixtures;

use App\Entity\Patient;
use App\Entity\Medecin;
use App\Enum\Sexe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PatientFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordHasherInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager): void
    {

        $medecin1 = $manager->getRepository(Medecin::class)->find(1);
        $medecin2 = $manager->getRepository(Medecin::class)->find(2);
        $patient1 = new Patient();
        $patient1->setNom("Durand")
                 ->setMedecinPerso($medecin1)
                 ->setPrenom("Jean")
                 ->setSexe(Sexe::HOMME)
                 ->setNumSecuSociale("1234567890123")
                 ->setNumTel("0601020304")
                 ->setDateNaissance(new \DateTime('1990-05-15'))
                 ->SetUsername("patient1")
                 ->setPassword($this->passwordEncoder->hashPassword($patient1, 'password123'))
                 ->setRoles(['ROLE_PATIENT']);

        $patient2 = new Patient();
        $patient2->setNom("Lefevre")
                 ->setMedecinPerso($medecin1)
                 ->setPrenom("Claire")
                 ->setSexe(Sexe::FEMME)
                 ->setNumSecuSociale("2345678901234")
                 ->setNumTel("0612345678")
                 ->setDateNaissance(new \DateTime('1985-11-22'))
                 ->SetUsername("patient2")
                 ->setPassword($this->passwordEncoder->hashPassword($patient2, 'password123'))
                 ->setRoles(['ROLE_PATIENT']);

        $patient3 = new Patient();
        $patient3->setNom("Bertin")
                 ->setPrenom("Paul")
                 ->setMedecinPerso($medecin2)
                 ->setSexe(Sexe::HOMME)
                 ->setNumSecuSociale("3456789012345")
                 ->setNumTel("0623456789")
                 ->setDateNaissance(new \DateTime('1992-01-30'))
                 ->SetUsername("patient3")
                 ->setPassword($this->passwordEncoder->hashPassword($patient3, 'password123'))
                 ->setRoles(['ROLE_PATIENT']);

        // Persister les patients
        $manager->persist($patient1);
        $manager->persist($patient2);
        $manager->persist($patient3);

        // Sauvegarde en base de données
        $manager->flush();
    }
}
