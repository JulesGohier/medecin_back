<?php

namespace App\DataFixtures;

use App\Entity\Patient;
use App\Entity\Medecin;
use App\Enum\Sexe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PatientFixtures extends Fixture
{
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
                 ->setDateNaissance(new \DateTime('1990-05-15'));

        $patient2 = new Patient();
        $patient2->setNom("Lefevre")
                 ->setMedecinPerso($medecin1)
                 ->setPrenom("Claire")
                 ->setSexe(Sexe::FEMME)
                 ->setNumSecuSociale("2345678901234")
                 ->setNumTel("0612345678")
                 ->setDateNaissance(new \DateTime('1985-11-22'));

        $patient3 = new Patient();
        $patient3->setNom("Bertin")
                 ->setPrenom("Paul")
                 ->setMedecinPerso($medecin2)
                 ->setSexe(Sexe::HOMME)
                 ->setNumSecuSociale("3456789012345")
                 ->setNumTel("0623456789")
                 ->setDateNaissance(new \DateTime('1992-01-30'));

        // Persister les patients
        $manager->persist($patient1);
        $manager->persist($patient2);
        $manager->persist($patient3);

        // Sauvegarde en base de données
        $manager->flush();
    }
}
