<?php
namespace App\DataFixtures;

use App\Entity\Admin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordHasherInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager): void
    {
        $admin1 = new Admin();
        $admin1 ->SetEmail("admin@admin.com")
                ->setPassword($this->passwordEncoder->hashPassword($admin1, 'password123'));
                 
        // Persist each Admin
        $manager->persist($admin1);

        // Sauvegarde en base de données
        $manager->flush();
    }
}
