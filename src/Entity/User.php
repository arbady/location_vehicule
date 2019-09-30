<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Form\FormTypeInterface;
use Onurb\Doctrine\ORMMetadataGrapher\Mapping as Grapher;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @Grapher\Color("khaki")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sexe;

    /**
     * @ORM\Column(type="date")
     */
    private $date_naissance;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="date")
     */
    private $date_inscription;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string")
     */
    private $telephone;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string le token qui servira lors de l'oubli de mot de passe
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $resetToken;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reservation", mappedBy="user")
     */
    private $reservations;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Permis")
     */
    private $permis;

    public function __construct()
    {
        $this->permis = new ArrayCollection();
        $this->reservations = new ArrayCollection();
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function getNom(): ?string
    {
        return $this->nom;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->date_naissance;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function setDateNaissance(\DateTimeInterface $date_naissance): self
    {
        $this->date_naissance = $date_naissance;

        return $this;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->date_inscription;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function setDateInscription(\DateTimeInterface $date_inscription): self
    {
        $this->date_inscription = $date_inscription;

        return $this;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     * @Grapher\IsDisplayedMethod()
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return string
     */
    public function getResetToken(): ?string
    {
        return $this->resetToken;
    }

    /**
     * @param string $resetToken
     */
    public function setResetToken(?string $resetToken): void
    {
        $this->resetToken = $resetToken;
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setUser($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->contains($reservation)) {
            $this->reservations->removeElement($reservation);
            // set the owning side to null (unless already changed)
            if ($reservation->getUser() === $this) {
                $reservation->setUser(null);
            }
        }

        return $this;
    }

    public function getUser(): ?self
    {
        return $this->user;
    }

    public function setUser(?self $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Permis[]
     */
    public function getPermis(): Collection
    {
        return $this->permis;
    }

    public function addPermi(Permis $permi): self
    {
        if (!$this->permis->contains($permi)) {
            $this->permis[] = $permi;
        }

        return $this;
    }

    public function removePermi(Permis $permi): self
    {
        if ($this->permis->contains($permi)) {
            $this->permis->removeElement($permi);
        }

        return $this;
    }

    public function  __toString()
    {
        return  $this->nom;
    }
}
