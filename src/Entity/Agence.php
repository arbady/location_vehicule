<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Onurb\Doctrine\ORMMetadataGrapher\Mapping as Grapher;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AgenceRepository")
 * @Grapher\Color("khaki")
 */
class Agence
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $aeroport;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ville;

    /**
     * @ORM\Column(type="integer")
     */
    private $code_postal;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pays;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reservation", mappedBy="agence")
     */
    private $reservations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Disponibilite", mappedBy="agence")
     */
    private $disponibilites;

//    /**
//     * @ORM\ManyToMany(targetEntity="App\Entity\vehicule", inversedBy="agences")
//     */
//    private $vehicule;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
        $this->disponibilites = new ArrayCollection();
//        $this->vehicule = new ArrayCollection();
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
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     * @param string $code
     * @return Agence
     */
    public function setCode(string $code): self
    {
        $this->code = $code;

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
    public function getAeroport(): ?string
    {
        return $this->aeroport;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function setAeroport(string $aeroport): self
    {
        $this->aeroport = $aeroport;

        return $this;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function getVille(): ?string
    {
        return $this->ville;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function getCodePostal(): ?int
    {
        return $this->code_postal;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function setCodePostal(int $code_postal): self
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function getPays(): ?string
    {
        return $this->pays;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function setPays(string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * @return Collection|Reservation[]
     * @Grapher\IsDisplayedMethod()
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setAgence($this);
        }

        return $this;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->contains($reservation)) {
            $this->reservations->removeElement($reservation);
            // set the owning side to null (unless already changed)
            if ($reservation->getAgence() === $this) {
                $reservation->setAgence(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Disponibilite[]
     * @Grapher\IsDisplayedMethod()
     */
    public function getDisponibilites(): Collection
    {
        return $this->disponibilites;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function addDisponibilite(Disponibilite $disponibilite): self
    {
        if (!$this->disponibilites->contains($disponibilite)) {
            $this->disponibilites[] = $disponibilite;
            $disponibilite->setAgence($this);
        }

        return $this;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function removeDisponibilite(Disponibilite $disponibilite): self
    {
        if ($this->disponibilites->contains($disponibilite)) {
            $this->disponibilites->removeElement($disponibilite);
            // set the owning side to null (unless already changed)
            if ($disponibilite->getAgence() === $this) {
                $disponibilite->setAgence(null);
            }
        }

        return $this;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function  __toString()
    {
        return  $this->adresse;
    }

//    /**
//     * @return Collection|vehicule[]
//     */
//    public function getVehicule(): Collection
//    {
//        return $this->vehicule;
//    }
//
//    public function addVehicule(vehicule $vehicule): self
//    {
//        if (!$this->vehicule->contains($vehicule)) {
//            $this->vehicule[] = $vehicule;
//        }
//
//        return $this;
//    }
//
//    public function removeVehicule(vehicule $vehicule): self
//    {
//        if ($this->vehicule->contains($vehicule)) {
//            $this->vehicule->removeElement($vehicule);
//        }
//
//        return $this;
//    }
}
