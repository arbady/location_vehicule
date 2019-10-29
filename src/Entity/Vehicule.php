<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Onurb\Doctrine\ORMMetadataGrapher\Mapping as Grapher;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VehiculeRepository")
 * @ORM\Table(name="vehicule")
 * @UniqueEntity("matricule")
 * @Grapher\Color("khaki")
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
     * @Assert\NotBlank(message="Champ vide.")
     * @Assert\Length(max=10)
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $matricule;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $caracteristiques;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categorie", inversedBy="vehicules")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Etat", inversedBy="vehicules", cascade ={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $etat;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Disponibilite", mappedBy="vehicule")
     */
    private $disponibilites;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Contrat", mappedBy="vehicule")
     */
    private $contrats;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Modele", inversedBy="vehicules")
     * @ORM\JoinColumn(nullable=false)
     */
    private $modele;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $images;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbPlace;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $transmission;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbPorte;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $carburant;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $airCo;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $gps;

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    private $lieu_vehic;

//    /**
//     * @ORM\ManyToMany(targetEntity="App\Entity\Agence", mappedBy="vehicule")
//     */
//    private $agences;

    public function __construct()
    {
//        $this->modele = new ArrayCollection();
        $this->disponibilites = new ArrayCollection();
        $this->contrats = new ArrayCollection();
//        $this->agences = new ArrayCollection();
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
    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function setMatricule(string $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function getCaracteristiques(): ?string
    {
        return $this->caracteristiques;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function setCaracteristiques(string $caracteristiques): self
    {
        $this->caracteristiques = $caracteristiques;

        return $this;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function getContrat(): ?Contrat
    {
        return $this->contrat;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function setContrat(?Contrat $contrat): self
    {
        $this->contrat = $contrat;

        return $this;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function getEtat(): ?Etat
    {
        return $this->etat;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function setEtat(?Etat $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

//    /**
//     * @return Collection|Modele[]
//     */
//    public function getModele(): Collection
//    {
//        return $this->modele;
//    }
    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function addModele(Modele $modele): self
    {
        if (!$this->modele->contains($modele)) {
            $this->modele[] = $modele;
            $modele->setVehicule($this);
        }

        return $this;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
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
            $disponibilite->setVehicule($this);
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
            if ($disponibilite->getVehicule() === $this) {
                $disponibilite->setVehicule(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Contrat[]
     * @Grapher\IsDisplayedMethod()
     */
    public function getContrats(): Collection
    {
        return $this->contrats;
    }

    public function addContrat(Contrat $contrat): self
    {
        if (!$this->contrats->contains($contrat)) {
            $this->contrats[] = $contrat;
            $contrat->setVehicule($this);
        }

        return $this;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function removeContrat(Contrat $contrat): self
    {
        if ($this->contrats->contains($contrat)) {
            $this->contrats->removeElement($contrat);
            // set the owning side to null (unless already changed)
            if ($contrat->getVehicule() === $this) {
                $contrat->setVehicule(null);
            }
        }

        return $this;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function getModele(): ?Modele
    {
        return $this->modele;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function setModele(?Modele $modele): self
    {
        $this->modele = $modele;

        return $this;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function  __toString()
    {
        return  $this->matricule;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function getImages(): ?string
    {
        return $this->images;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     * @param string|null $images
     * @return Vehicule
     */
    public function setImages(?string $images): self
    {
        $this->images = $images;

        return $this;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function getNbPlace(): ?int
    {
        return $this->nbPlace;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     * @param int|null $nbPlace
     * @return Vehicule
     */
    public function setNbPlace(?int $nbPlace): self
    {
        $this->nbPlace = $nbPlace;

        return $this;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function getTransmission(): ?string
    {
        return $this->transmission;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     * @param string|null $transmission
     * @return Vehicule
     */
    public function setTransmission(?string $transmission): self
    {
        $this->transmission = $transmission;

        return $this;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function getNbPorte(): ?int
    {
        return $this->nbPorte;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function setNbPorte(?int $nbPorte): self
    {
        $this->nbPorte = $nbPorte;

        return $this;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function getCarburant(): ?string
    {
        return $this->carburant;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function setCarburant(?string $carburant): self
    {
        $this->carburant = $carburant;

        return $this;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function getAirCo(): ?string
    {
        return $this->airCo;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function setAirCo(?string $airCo): self
    {
        $this->airCo = $airCo;

        return $this;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function getGps(): ?string
    {
        return $this->gps;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function setGps(?string $gps): self
    {
        $this->gps = $gps;

        return $this;
    }

    public function getLieuVehic(): ?string
    {
        return $this->lieu_vehic;
    }

    public function setLieuVehic(?string $lieu_vehic): self
    {
        $this->lieu_vehic = $lieu_vehic;

        return $this;
    }

//    /**
//     * @return Collection|Agence[]
//     */
//    public function getAgences(): Collection
//    {
//        return $this->agences;
//    }
//
//    public function addAgence(Agence $agence): self
//    {
//        if (!$this->agences->contains($agence)) {
//            $this->agences[] = $agence;
//            $agence->addVehicule($this);
//        }
//
//        return $this;
//    }
//
//    public function removeAgence(Agence $agence): self
//    {
//        if ($this->agences->contains($agence)) {
//            $this->agences->removeElement($agence);
//            $agence->removeVehicule($this);
//        }
//
//        return $this;
//    }
}
