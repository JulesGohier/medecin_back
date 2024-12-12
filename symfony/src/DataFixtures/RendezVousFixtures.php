<?php

namespace App\DataFixtures;

use App\Entity\Medecin;
use App\Entity\Patient;
use App\Entity\RendezVous;
use App\Enum\State;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RendezVousFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // On récupère les références des médecins et patients créés
        $medecin1 = $manager->getRepository(Medecin::class)->find(1);
        $medecin2 = $manager->getRepository(Medecin::class)->find(2);
        $patient1 = $manager->getRepository(Patient::class)->find(1);
        $patient2 = $manager->getRepository(Patient::class)->find(2);
        
        // Création de 3 rendez-vous
        $rendezVous1 = new RendezVous();
        $rendezVous1->setIdMedecin($medecin1)
                    ->setIdPatient($patient1)
                    ->setDate(new \DateTime('2024-12-15 10:00:00'))
                    ->setState(State::RESERVE);

        $rendezVous2 = new RendezVous();
        $rendezVous2->setIdMedecin($medecin2)
                    ->setIdPatient($patient2)
                    ->setDate(new \DateTime('2024-12-16 14:00:00'))
                    ->setState(State::ANNULE);

        $rendezVous3 = new RendezVous();
        $rendezVous3->setIdMedecin($medecin1)
                    ->setIdPatient($patient2)
                    ->setDate(new \DateTime('2024-12-17 16:00:00'))
                    ->setState(State::PASSE);

        // Persister les rendez-vous
        $manager->persist($rendezVous1);
        $manager->persist($rendezVous2);
        $manager->persist($rendezVous3);

        // Sauvegarde en base de données
        $manager->flush();
    }
}
