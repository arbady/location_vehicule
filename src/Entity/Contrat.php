<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContratRepository")
 */
class Contrat
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $num_contrat;

    /**
     * @ORM\Column(type="date")
     */
    private $date_retour_reelle;

    /**
     * @ORM\Column(type="integer")
     */
    private $km_depart;

    /**
     * @ORM\Column(type="integer")
     */
    private $km_retour;

    /**
     * @ORM\Column(type="date")
     */
    private $date_contrat;

    /**
     * @ORM\Column(type="float")
     */
    private $montant_tot_htva;

    /**
     * @ORM\Column(type="float")
     */
    private $montant_tot_tva;

    /**
     * @ORM\Column(type="boolean")
     */
    private $signe;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Penalisation", mappedBy="contrat")
     */
    private $penalisations;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Vehicule", inversedBy="contrats")
     * @ORM\JoinColumn(nullable=false)
     */
    private $vehicule;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Reservation", inversedBy="contrat", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $reservation;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Facture", mappedBy="contrat", cascade={"persist", "remove"})
     */
    private $facture;

    public function __construct()
    {
        $this->vehicule = new ArrayCollection();
        $this->penalisations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumContrat(): ?int
    {
        return $this->num_contrat;
    }

    public function setNumContrat(int $num_contrat): self
    {
        $this->num_contrat = $num_contrat;

        return $this;
    }

    public function getDateRetourReelle(): ?\DateTimeInterface
    {
        return $this->date_retour_reelle;
    }

    public function setDateRetourReelle(\DateTimeInterface $date_retour_reelle): self
    {
        $this->date_retour_reelle = $date_retour_reelle;

        return $this;
    }

    public function getKmDepart(): ?int
    {
        return $this->km_depart;
    }

    public function setKmDepart(int $km_depart): self
    {
        $this->km_depart = $km_depart;

        return $this;
    }

    public function getKmRetour(): ?int
    {
        return $this->km_retour;
    }

    public function setKmRetour(int $km_retour): self
    {
        $this->km_retour = $km_retour;

        return $this;
    }

    public function getDateContrat(): ?\DateTimeInterface
    {
        return $this->date_contrat;
    }

    public function setDateContrat(\DateTimeInterface $date_contrat): self
    {
        $this->date_contrat = $date_contrat;

        return $this;
    }

    public function getMontantTotHtva(): ?float
    {
        return $this->montant_tot_htva;
    }

    public function setMontantTotHtva(float $montant_tot_htva): self
    {
        $this->montant_tot_htva = $montant_tot_htva;

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

    public function getSigne(): ?bool
    {
        return $this->signe;
    }

    public function setSigne(bool $signe): self
    {
        $this->signe = $signe;

        return $this;
    }

    public function getPenalisation(): ?Penalisation
    {
        return $this->penalisation;
    }

    public function setPenalisation(?Penalisation $penalisation): self
    {
        $this->penalisation = $penalisation;

        // set (or unset) the owning side of the relation if necessary
        $newContrat = $penalisation === null ? null : $this;
        if ($newContrat !== $penalisation->getContrat()) {
            $penalisation->setContrat($newContrat);
        }

        return $this;
    }

    public function getReservation(): ?Reservation
    {
        return $this->reservation;
    }

    public function setReservation(?Reservation $reservation): self
    {
        $this->reservation = $reservation;

        return $this;
    }

    /**
     * @return Collection|Vehicule[]
     */
    public function getVehicule(): Collection
    {
        return $this->vehicule;
    }

    public function addVehicule(Vehicule $vehicule): self
    {
        if (!$this->vehicule->contains($vehicule)) {
            $this->vehicule[] = $vehicule;
            $vehicule->setContrat($this);
        }

        return $this;
    }

    public function removeVehicule(Vehicule $vehicule): self
    {
        if ($this->vehicule->contains($vehicule)) {
            $this->vehicule->removeElement($vehicule);
            // set the owning side to null (unless already changed)
            if ($vehicule->getContrat() === $this) {
                $vehicule->setContrat(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Penalisation[]
     */
    public function getPenalisations(): Collection
    {
        return $this->penalisations;
    }

    public function addPenalisation(Penalisation $penalisation): self
    {
        if (!$this->penalisations->contains($penalisation)) {
            $this->penalisations[] = $penalisation;
            $penalisation->setContrat($this);
        }

        return $this;
    }

    public function removePenalisation(Penalisation $penalisation): self
    {
        if ($this->penalisations->contains($penalisation)) {
            $this->penalisations->removeElement($penalisation);
            // set the owning side to null (unless already changed)
            if ($penalisation->getContrat() === $this) {
                $penalisation->setContrat(null);
            }
        }

        return $this;
    }

    public function setVehicule(?Vehicule $vehicule): self
    {
        $this->vehicule = $vehicule;

        return $this;
    }

    public function getFacture(): ?Facture
    {
        return $this->facture;
    }

    public function setFacture(Facture $facture): self
    {
        $this->facture = $facture;

        // set the owning side of the relation if necessary
        if ($this !== $facture->getContrat()) {
            $facture->setContrat($this);
        }

        return $this;
    }
}
