<?php

namespace App\Entity;

use App\Enum\State;
use App\Repository\RendezVousRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RendezVousRepository::class)]
class RendezVous
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'Rdv')]
    private ?Medecin $id_medecin = null;

    #[ORM\ManyToOne(inversedBy: 'Rdv')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Patient $id_patient = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(enumType: State::class)]
    private ?State $state = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdMedecin(): ?Medecin
    {
        return $this->id_medecin;
    }

    public function setIdMedecin(?Medecin $id_medecin): static
    {
        $this->id_medecin = $id_medecin;

        return $this;
    }

    public function getIdPatient(): ?Patient
    {
        return $this->id_patient;
    }

    public function setIdPatient(?Patient $id_patient): static
    {
        $this->id_patient = $id_patient;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getState(): ?State
    {
        return $this->state;
    }

    public function setState(State $state): static
    {
        $this->state = $state;

        return $this;
    }
}
