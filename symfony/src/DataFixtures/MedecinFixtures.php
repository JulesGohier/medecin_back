<?php
namespace App\DataFixtures;

use App\Entity\Medecin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class MedecinFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordHasherInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager): void
    {
        // Création de 3 médecins
        $medecin1 = new Medecin();
        $medecin1->setNom("Jean")
                 ->setPrenom("Dupont")
                 ->setNumRpps("123456789012")
                 ->setNumTel("0123456789")
                 ->SetEmail("medecin1@medecin.com")
                 ->setSpecialite("Medecin Généraliste")
                 ->setPassword($this->passwordEncoder->hashPassword($medecin1, 'password123'));

        $medecin2 = new Medecin();
        $medecin2->setNom("Martin")
                 ->setPrenom("Marie")
                 ->setNumRpps("987654321098")
                 ->setNumTel("0987654321")
                 ->SetEmail("medecin2@medecin.com")
                 ->setSpecialite("Ostéopathe")
                 ->setPassword($this->passwordEncoder->hashPassword($medecin2, 'password123'));

        $medecin3 = new Medecin();
        $medecin3->setNom("Lemoine")
                 ->setPrenom("Luc")
                 ->setNumRpps("112233445566")
                 ->setNumTel("0147258364")
                 ->SetEmail("medecin3@medecin.com")
                 ->setSpecialite("Ostéopathe")
                 ->setPassword($this->passwordEncoder->hashPassword($medecin3, 'password123'));
                 
        // Persist each Medecin
        $manager->persist($medecin1);
        $manager->persist($medecin2);
        $manager->persist($medecin3);

        // Sauvegarde en base de données
        $manager->flush();
    }
}
