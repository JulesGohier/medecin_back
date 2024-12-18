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
                ->setApiToken('eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE3MzQ0NDg3NzgsImV4cCI6MzY2NjY4NDAxMTA4Nzc4LCJyb2xlcyI6WyJST0xFX01FREVDSU4iLCJST0xFX1VTRVIiXSwidXNlcm5hbWUiOiJtZWRlY2luIn0.vgzl9x14gv1-9pTVQQgaeNN66jJklhZ3m9CMHi67Q8bWTlZ5HcPk59F_ZIRP7x-MeD0XyWvY1l3fu9u6cccon4IpO0XlhBhvJNNjDMZiZYy9LWVGe6iLuQ9w-UgmFPW0eKjLMFnCBFq8QCP7xKBIbj69MCWj6ImRHO24fSjBqKMTBRSL9ujyadH33HiKKTtgW5H88e8HWE7QcZilvgtnHIUB3gwdZsFsoGxKTGwHtofBomQoI3rLeWkUJXkGlhTPXf8VMaHdQmmGNY_ZIccscRwz_5niLqSLAoYfrPjtMum1XWX31nqI-JTtpmUUqfMQXJi8iq6V2Awp4WWv4nMbpx-N2oKIaFK8_5dnyuK76lSVotS4vLq8_pfFvkNsj468B1ZIWadKrlLDy-NzAhRlgPw2tXJTMUxxpOUrrJQ6LD0yN7axHAHitX6_oMkgxF9i2dIr7W6im6hA1MUfYJNoseCFwxxQw4Z7SOlfVg_vW91_T0U_YGPXim3FbaMCyzR128dy5gs1cQeZtcv5fMRpwxgCtmhsZuk70RdSXAyGHBXkx2hr_fVJbeMZRYr6LdqxAj5cKEH3OrvXWEmAXkcK7ec3SDHJrbe5_1G5zV-t9x5hj12gLn3asHTJd3rtPzFDZ1McIvuckjbwXSfMpoHVN7g1ufAFxyDpF24vzvZHrD0')
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
