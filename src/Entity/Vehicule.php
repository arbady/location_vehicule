<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VehiculeRepository")
 */
class Vehicule
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
    private $matricule;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $caracteristiques;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Contrat", inversedBy="vehicule")
     * @ORM\JoinColumn(nullable=false)
     */
    private $contrat;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categorie", inversedBy="vehicules")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Etat", inversedBy="vehicules")
     * @ORM\JoinColumn(nullable=false)
     */
    private $etat;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Modele", mappedBy="vehicule")
     */
    private $modele;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Disponibilite", mappedBy="vehicule")
     */
    private $disponibilites;

    public function __construct()
    {
        $this->modele = new ArrayCollection();
        $this->disponibilites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getCaracteristiques(): ?string
    {
        return $this->caracteristiques;
    }

    public function setCaracteristiques(string $caracteristiques): self
    {
        $this->caracteristiques = $caracteristiques;

        return $this;
    }

    public function getContrat(): ?Contrat
    {
        return $this->contrat;
    }

    public function setContrat(?Contrat $contrat): self
    {
        $this->contrat = $contrat;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getEtat(): ?Etat
    {
        return $this->etat;
    }

    public function setEtat(?Etat $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * @return Collection|Modele[]
     */
    public function getModele(): Collection
    {
        return $this->modele;
    }

    public function addModele(Modele $modele): self
    {
        if (!$this->modele->contains($modele)) {
            $this->modele[] = $modele;
            $modele->setVehicule($this);
        }

        return $this;
    }

    public function removeModele(Modele $modele): self
    {
        if ($this->modele->contains($modele)) {
            $this->modele->removeElement($modele);
            // set the owning side to null (unless already changed)
            if ($modele->getVehicule() === $this) {
                $modele->setVehicule(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Disponibilite[]
     */
    public function getDisponibilites(): Collection
    {
        return $this->disponibilites;
    }

    public function addDisponibilite(Disponibilite $disponibilite): self
    {
        if (!$this->disponibilites->contains($disponibilite)) {
            $this->disponibilites[] = $disponibilite;
            $disponibilite->setVehicule($this);
        }

        return $this;
    }

    public function removeDisponibilite(Disponibilite $disponibilite): self
    {
        if ($this->disponibilites->contains($disponibilite)) {
            $this->disponibilites->removeElement($disponibilite);
            // set the owning side to null (unless already changed)
            if ($disponibilite->getVehicule() === $this) {
                $disponibilite->setVehicule(null);
            }
        }

        return $this;
    }
}
