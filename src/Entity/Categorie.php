<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Onurb\Doctrine\ORMMetadataGrapher\Mapping as Grapher;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategorieRepository")
 * @Grapher\Color("khaki")
 */
class Categorie
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
    private $type_cat;

    /**
     * @ORM\Column(type="float")
     */
    private $cout_par_jour;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reservation", mappedBy="categorie")
     */
    private $reservations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Vehicule", mappedBy="categorie")
     */
    private $vehicules;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
        $this->vehicules = new ArrayCollection();
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
    public function getTypeCat(): ?string
    {
        return $this->type_cat;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function setTypeCat(string $type_cat): self
    {
        $this->type_cat = $type_cat;

        return $this;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function getCoutParJour(): ?float
    {
        return $this->cout_par_jour;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function setCoutParJour(float $cout_par_jour): self
    {
        $this->cout_par_jour = $cout_par_jour;

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
            $reservation->setCategorie($this);
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
            if ($reservation->getCategorie() === $this) {
                $reservation->setCategorie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Vehicule[]
     * @Grapher\IsDisplayedMethod()
     */
    public function getVehicules(): Collection
    {
        return $this->vehicules;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function addVehicule(Vehicule $vehicule): self
    {
        if (!$this->vehicules->contains($vehicule)) {
            $this->vehicules[] = $vehicule;
            $vehicule->setCategorie($this);
        }

        return $this;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function removeVehicule(Vehicule $vehicule): self
    {
        if ($this->vehicules->contains($vehicule)) {
            $this->vehicules->removeElement($vehicule);
            // set the owning side to null (unless already changed)
            if ($vehicule->getCategorie() === $this) {
                $vehicule->setCategorie(null);
            }
        }

        return $this;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function  __toString()
    {
        return  $this->type_cat;
    }
}
