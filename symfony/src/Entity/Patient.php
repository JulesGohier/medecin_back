<?php

namespace App\Entity;

use App\Enum\Sexe;
use App\Repository\PatientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PatientRepository::class)]
class Patient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(enumType: Sexe::class)]
    private ?Sexe $sexe = null;

    #[ORM\Column(length: 255)]
    private ?string $num_secu_sociale = null;

    #[ORM\ManyToOne(inversedBy: 'patients')]
    private ?Medecin $medecin_perso = null;

    #[ORM\Column(type: Types::BIGINT, nullable: true)]
    private ?string $num_tel = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $antecedent = null;

    /**
     * @var Collection<int, RendezVous>
     */
    #[ORM\OneToMany(targetEntity: RendezVous::class, mappedBy: 'id_patient', orphanRemoval: true)]
    private Collection $Rdv;

    public function __construct()
    {
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

    public function getSexe(): ?Sexe
    {
        return $this->sexe;
    }

    public function setSexe(Sexe $sexe): static
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getNumSecuSociale(): ?string
    {
        return $this->num_secu_sociale;
    }

    public function setNumSecuSociale(string $num_secu_sociale): static
    {
        $this->num_secu_sociale = $num_secu_sociale;

        return $this;
    }

    public function getMedecinPerso(): ?Medecin
    {
        return $this->medecin_perso;
    }

    public function setMedecinPerso(?Medecin $medecin_perso): static
    {
        $this->medecin_perso = $medecin_perso;

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

    public function getAntecedent(): ?string
    {
        return $this->antecedent;
    }

    public function setAntecedent(?string $antecedent): static
    {
        $this->antecedent = $antecedent;

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
            $rdv->setIdPatient($this);
        }

        return $this;
    }

    public function removeRdv(RendezVous $rdv): static
    {
        if ($this->Rdv->removeElement($rdv)) {
            // set the owning side to null (unless already changed)
            if ($rdv->getIdPatient() === $this) {
                $rdv->setIdPatient(null);
            }
        }

        return $this;
    }
}
