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
        // Création de 5 médecins avec plus de médecins généralistes et des emails réalistes
        $medecin1 = new Medecin();
        $medecin1->setNom("Jean")
            ->setPrenom("Dupont")
            ->setNumRpps("123456789012")
            ->setNumTel("0123456789")
            ->setEmail("jean.dupont@medecins.fr")
            ->setSpecialite("Médecin Généraliste")
            ->setPassword('password123');

        $medecin2 = new Medecin();
        $medecin2->setNom("Martin")
            ->setPrenom("Marie")
            ->setNumRpps("987654321098")
            ->setNumTel("0987654321")
            ->setEmail("marie.martin@medecins.fr")
            ->setSpecialite("Médecin Généraliste")
            ->setPassword('password123');

        $medecin3 = new Medecin();
        $medecin3->setNom("Lemoine")
            ->setPrenom("Luc")
            ->setNumRpps("112233445566")
            ->setNumTel("0147258364")
            ->setEmail("luc.lemoine@medecins.fr")
            ->setSpecialite("Médecin Généraliste")
            ->setPassword('password123');

        $medecin4 = new Medecin();
        $medecin4->setNom("Durand")
            ->setPrenom("Sophie")
            ->setNumRpps("223344556677")
            ->setNumTel("0178456123")
            ->setEmail("sophie.durand@medecins.fr")
            ->setSpecialite("Médecin Généraliste")
            ->setPassword('password123');

        $medecin5 = new Medecin();
        $medecin5->setNom("Bernard")
            ->setPrenom("Paul")
            ->setNumRpps("334455667788")
            ->setNumTel("0189564732")
            ->setEmail("paul.bernard@medecins.fr")
            ->setSpecialite("Ostéopathe")
            ->setPassword('password123');

        // Persist each Medecin
        $manager->persist($medecin1);
        $manager->persist($medecin2);
        $manager->persist($medecin3);
        $manager->persist($medecin4);
        $manager->persist($medecin5);

        // Sauvegarde en base de données
        $manager->flush();

    }
}
