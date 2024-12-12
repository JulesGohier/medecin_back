<?php
namespace App\DataFixtures;

use App\Entity\Medecin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MedecinFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Création de 3 médecins
        $medecin1 = new Medecin();
        $medecin1->setNom("Dupont")
                 ->setPrenom("Pierre")
                 ->setNumRpps("123456789012")
                 ->setNumTel("0123456789");

        $medecin2 = new Medecin();
        $medecin2->setNom("Martin")
                 ->setPrenom("Marie")
                 ->setNumRpps("987654321098")
                 ->setNumTel("0987654321");

        $medecin3 = new Medecin();
        $medecin3->setNom("Lemoine")
                 ->setPrenom("Luc")
                 ->setNumRpps("112233445566")
                 ->setNumTel("0147258364");

        // Persist each Medecin
        $manager->persist($medecin1);
        $manager->persist($medecin2);
        $manager->persist($medecin3);

        // Sauvegarde en base de données
        $manager->flush();
    }
}
