<?php 

namespace App\EventListener;

use App\Entity\Patient;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PatientListener
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function prePersist(PrePersistEventArgs $event): void
    {
        $entity = $event->getObject();

        if (!$entity instanceof Patient) {
            return;
        }

        $this->encodePassword($entity);
    }

    public function preUpdate(PreUpdateEventArgs $event): void
    {
        $entity = $event->getObject();

        if (!$entity instanceof Patient) {
            return;
        }

        if ($event->hasChangedField('password')) {
            $this->encodePassword($entity);
        }
    }

    private function encodePassword(Patient $patient): void
    {
        if ($patient->getPassword()) {
            $hashedPassword = $this->passwordHasher->hashPassword($patient, $patient->getPassword());
            $patient->setPassword($hashedPassword);
        }
    }
}
