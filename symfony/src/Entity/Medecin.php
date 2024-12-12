<?php

namespace App\Entity;

use App\Repository\MedecinRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ApiResource]
#[ORM\Entity(repositoryClass: MedecinRepository::class)]
class Medecin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $num_rpps = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $num_tel = null;

    /**
     * @var Collection<int, Patient>
     */
    #[ORM\OneToMany(targetEntity: Patient::class, mappedBy: 'medecin_perso')]
    private Collection $patients;

    /**
     * @var Collection<int, RendezVous>
     */
    #[ORM\OneToMany(targetEntity: RendezVous::class, mappedBy: 'id_medecin')]
    private Collection $Rdv;

    public function __construct()
    {
        $this->patients = new ArrayCollection();
        $this->Rdv = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNumRpps(): ?string
    {
        return $this->num_rpps;
    }

    public function setNumRpps(string $num_rpps): static
    {
        $this->num_rpps = $num_rpps;

        return $this;
    }

    public function getNumTel(): ?string
    {
        return $this->num_tel;
    }

    public function setNumTel(?string $num_tel): static
    {
        $this->num_tel = $num_tel;

        return $this;
    }

    /**
     * @return Collection<int, Patient>
     */
    public function getPatients(): Collection
    {
        return $this->patients;
    }

    public function addPatient(Patient $patient): static
    {
        if (!$this->patients->contains($patient)) {
            $this->patients->add($patient);
            $patient->setMedecinPerso($this);
        }

        return $this;
    }

    public function removePatient(Patient $patient): static
    {
        if ($this->patients->removeElement($patient)) {
            // set the owning side to null (unless already changed)
            if ($patient->getMedecinPerso() === $this) {
                $patient->setMedecinPerso(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RendezVous>
     */
    public function getRdv(): Collection
    {
        return $this->Rdv;
    }

    public function addRdv(RendezVous $rdv): static
    {
        if (!$this->Rdv->contains($rdv)) {
            $this->Rdv->add($rdv);
            $rdv->setIdMedecin($this);
        }

        return $this;
    }

    public function removeRdv(RendezVous $rdv): static
    {
        if ($this->Rdv->removeElement($rdv)) {
            // set the owning side to null (unless already changed)
            if ($rdv->getIdMedecin() === $this) {
                $rdv->setIdMedecin(null);
            }
        }

        return $this;
    }
}
