<?php

namespace App\Entity;

use App\Enum\State;
use App\Repository\RendezVousRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ApiResource]
#[ORM\Entity(repositoryClass: RendezVousRepository::class)]
class RendezVous
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Medecin::class, inversedBy: 'Rdv')]
    #[ORM\JoinColumn(name: 'rpps_medecin', referencedColumnName: 'num_rpps', nullable: false)]
    private ?Medecin $rpps_medecin = null;

    #[ORM\ManyToOne(targetEntity: Patient::class, inversedBy: 'Rdv')]
    #[ORM\JoinColumn(name: 'patient_num_secu_sociale', referencedColumnName: 'num_secu_sociale', nullable: false)]
    private ?Patient $num_secu_sociale_patient = null;


    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(enumType: State::class)]
    private ?State $state = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $annule_par = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdMedecin(): ?Medecin
    {
        return $this->rpps_medecin;
    }

    public function setIdMedecin(?Medecin $rpps_medecin): static
    {
        $this->rpps_medecin = $rpps_medecin;

        return $this;
    }

    public function getIdPatient(): ?Patient
    {
        return $this->num_secu_sociale_patient;
    }

    public function setIdPatient(?Patient $num_secu_sociale_patient): static
    {
        $this->num_secu_sociale_patient = $num_secu_sociale_patient;

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

    public function getAnnulePar(): ?string
    {
        return $this->annule_par;
    }

    public function setAnnulePar(?string $annule_par): static
    {
        $this->annule_par = $annule_par;

        return $this;
    }
}
