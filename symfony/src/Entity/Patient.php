<?php

namespace App\Entity;


use ApiPlatform\Metadata\ApiResource;
use App\Enum\Sexe;
use App\Repository\PatientRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource]
#[ORM\Entity(repositoryClass: PatientRepository::class)]
class Patient implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 255)]
    private ?string $num_secu_sociale = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(enumType: Sexe::class)]
    private ?Sexe $sexe = null;

    #[ORM\ManyToOne(targetEntity: Medecin::class, inversedBy: 'patients')]
    #[ORM\JoinColumn(name: 'medecin_perso_num_rpps', referencedColumnName: 'num_rpps', nullable: true)]
    private ?Medecin $medecin_perso = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $num_tel = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $antecedent = null;

    /**
     * @var Collection<int, RendezVous>
     */
    #[ORM\OneToMany(targetEntity: RendezVous::class, mappedBy: 'num_secu_sociale_patient', orphanRemoval: true)]
    private Collection $Rdv;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_naissance = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column]
    private array $roles = ['ROLE_PATIENT'];

    public function __construct()
    {
        $this->Rdv = new ArrayCollection();
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

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->date_naissance;
    }

    public function setDateNaissance(?\DateTimeInterface $date_naissance): static
    {
        $this->date_naissance = $date_naissance;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

           /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }
    
        /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

}
