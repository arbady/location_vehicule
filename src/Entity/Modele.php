<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Onurb\Doctrine\ORMMetadataGrapher\Mapping as Grapher;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ModeleRepository")
 * @Grapher\Color("khaki")
 */
class Modele
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Marque", inversedBy="modeles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $marque;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Vehicule", mappedBy="modele")
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
    public function getVehicule(): ?Vehicule
    {
        return $this->vehicule;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function setVehicule(?Vehicule $vehicule): self
    {
        $this->vehicule = $vehicule;

        return $this;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function getMarque(): ?Marque
    {
        return $this->marque;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function setMarque(?Marque $marque): self
    {
        $this->marque = $marque;

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
            $vehicule->setModele($this);
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
            if ($vehicule->getModele() === $this) {
                $vehicule->setModele(null);
            }
        }

        return $this;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function  __toString()
    {
        return  $this->nom;
    }
}
