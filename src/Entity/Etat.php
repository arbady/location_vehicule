<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Onurb\Doctrine\ORMMetadataGrapher\Mapping as Grapher;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EtatRepository")
 * @Grapher\Color("khaki")
 */
class Etat
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
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Vehicule", mappedBy="etat")
     */
    private $vehicules;

    public function __construct()
    {
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
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

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
            $vehicule->setEtat($this);
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
            if ($vehicule->getEtat() === $this) {
                $vehicule->setEtat(null);
            }
        }

        return $this;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function  __toString()
    {
        return  $this->description;
    }
}
