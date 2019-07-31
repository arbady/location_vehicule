<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservationRepository")
 */
class Reservation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date_res;

    /**
     * @ORM\Column(type="date")
     */
    private $date_debut_loc;

    /**
     * @ORM\Column(type="date")
     */
    private $date_fin_loc;

    /**
     * @ORM\Column(type="float")
     */
    private $montant_tot_tva;

    /**
     * @ORM\Column(type="float")
     */
    private $acompte;

    /**
     * @ORM\Column(type="boolean")
     */
    private $acompte_paye;

    /**
     * @ORM\Column(type="boolean")
     */
    private $statut_res;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Agence", inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $agence;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categorie", inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Contrat", mappedBy="reservation", cascade={"persist", "remove"})
     */
    private $contrat;

    public function __construct()
    {
        $this->contrats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateRes(): ?\DateTimeInterface
    {
        return $this->date_res;
    }

    public function setDateRes(\DateTimeInterface $date_res): self
    {
        $this->date_res = $date_res;

        return $this;
    }

    public function getDateDebutLoc(): ?\DateTimeInterface
    {
        return $this->date_debut_loc;
    }

    public function setDateDebutLoc(\DateTimeInterface $date_debut_loc): self
    {
        $this->date_debut_loc = $date_debut_loc;

        return $this;
    }

    public function getDateFinLoc(): ?\DateTimeInterface
    {
        return $this->date_fin_loc;
    }

    public function setDateFinLoc(\DateTimeInterface $date_fin_loc): self
    {
        $this->date_fin_loc = $date_fin_loc;

        return $this;
    }

    public function getMontantTotTva(): ?float
    {
        return $this->montant_tot_tva;
    }

    public function setMontantTotTva(float $montant_tot_tva): self
    {
        $this->montant_tot_tva = $montant_tot_tva;

        return $this;
    }

    public function getAcompte(): ?float
    {
        return $this->acompte;
    }

    public function setAcompte(float $acompte): self
    {
        $this->acompte = $acompte;

        return $this;
    }

    public function getAcomptePaye(): ?bool
    {
        return $this->acompte_paye;
    }

    public function setAcomptePaye(bool $acompte_paye): self
    {
        $this->acompte_paye = $acompte_paye;

        return $this;
    }

    public function getStatutRes(): ?bool
    {
        return $this->statut_res;
    }

    public function setStatutRes(bool $statut_res): self
    {
        $this->statut_res = $statut_res;

        return $this;
    }

    public function getAgence(): ?Agence
    {
        return $this->agence;
    }

    public function setAgence(?Agence $agence): self
    {
        $this->agence = $agence;

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

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection|Contrat[]
     */
    public function getContrats(): Collection
    {
        return $this->contrats;
    }

    public function addContrat(Contrat $contrat): self
    {
        if (!$this->contrats->contains($contrat)) {
            $this->contrats[] = $contrat;
            $contrat->setReservation($this);
        }

        return $this;
    }

    public function removeContrat(Contrat $contrat): self
    {
        if ($this->contrats->contains($contrat)) {
            $this->contrats->removeElement($contrat);
            // set the owning side to null (unless already changed)
            if ($contrat->getReservation() === $this) {
                $contrat->setReservation(null);
            }
        }

        return $this;
    }

    public function getContrat(): ?Contrat
    {
        return $this->contrat;
    }

    public function setContrat(Contrat $contrat): self
    {
        $this->contrat = $contrat;

        // set the owning side of the relation if necessary
        if ($this !== $contrat->getReservation()) {
            $contrat->setReservation($this);
        }

        return $this;
    }
}
