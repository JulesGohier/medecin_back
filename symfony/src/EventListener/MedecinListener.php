<?php 

namespace App\EventListener;

use App\Entity\Medecin;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class MedecinListener
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function prePersist(PrePersistEventArgs $event): void
    {
        $entity = $event->getObject();

        if (!$entity instanceof Medecin) {
            return;
        }

        $this->encodePassword($entity);
    }

    public function preUpdate(PreUpdateEventArgs $event): void
    {
        $entity = $event->getObject();

        if (!$entity instanceof Medecin) {
            return;
        }

        if ($event->hasChangedField('password')) {
            $this->encodePassword($entity);
        }
    }

    private function encodePassword(Medecin $medecin): void
    {
        if ($medecin->getPassword()) {
            $hashedPassword = $this->passwordHasher->hashPassword($medecin, $medecin->getPassword());
            $medecin->setPassword($hashedPassword);
        }
    }
}
