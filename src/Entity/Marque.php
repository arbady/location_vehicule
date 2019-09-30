<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Onurb\Doctrine\ORMMetadataGrapher\Mapping as Grapher;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MarqueRepository")
 * @Grapher\Color("khaki")
 */
class Marque
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
     * @ORM\OneToMany(targetEntity="App\Entity\Modele", mappedBy="marque")
     */
    private $modeles;

    public function __construct()
    {
        $this->modeles = new ArrayCollection();
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
     * @return Collection|Modele[]
     * @Grapher\IsDisplayedMethod()
     */
    public function getModeles(): Collection
    {
        return $this->modeles;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function addModele(Modele $modele): self
    {
        if (!$this->modeles->contains($modele)) {
            $this->modeles[] = $modele;
            $modele->setMarque($this);
        }

        return $this;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function removeModele(Modele $modele): self
    {
        if ($this->modeles->contains($modele)) {
            $this->modeles->removeElement($modele);
            // set the owning side to null (unless already changed)
            if ($modele->getMarque() === $this) {
                $modele->setMarque(null);
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
