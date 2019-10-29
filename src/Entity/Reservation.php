<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Onurb\Doctrine\ORMMetadataGrapher\Mapping as Grapher;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservationRepository")
 * @Grapher\Color("khaki")
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
     * @ORM\Column(type="string", length=50)
     */
    private $agence_retour;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $couverture_dommage;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $couverture_vol;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $tranche_age;

    /**
     * @ORM\Column(type="boolean")
     */
    private $toutPaye;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Agence", inversedBy="reservations", cascade ={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $agence;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categorie", inversedBy="reservations", cascade ={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Contrat", mappedBy="reservation", cascade={"persist", "remove"})
     */
    private $contrat;

    public function __construct()
    {
        $this->contrats = new ArrayCollection();
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
    public function getDateRes(): ?\DateTimeInterface
    {
        return $this->date_res;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function setDateRes(\DateTimeInterface $date_res): self
    {
        $this->date_res = $date_res;

        return $this;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function getDateDebutLoc(): ?\DateTimeInterface
    {
        return $this->date_debut_loc;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function setDateDebutLoc(\DateTimeInterface $date_debut_loc): self
    {
        $this->date_debut_loc = $date_debut_loc;

        return $this;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function getDateFinLoc(): ?\DateTimeInterface
    {
        return $this->date_fin_loc;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function setDateFinLoc(\DateTimeInterface $date_fin_loc): self
    {
        $this->date_fin_loc = $date_fin_loc;

        return $this;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function getMontantTotTva(): ?float
    {
        return $this->montant_tot_tva;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function setMontantTotTva(float $montant_tot_tva): self
    {
        $this->montant_tot_tva = $montant_tot_tva;

        return $this;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function getAcompte(): ?float
    {
        return $this->acompte;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function setAcompte(float $acompte): self
    {
        $this->acompte = $acompte;

        return $this;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function getAcomptePaye(): ?bool
    {
        return $this->acompte_paye;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function setAcomptePaye(bool $acompte_paye): self
    {
        $this->acompte_paye = $acompte_paye;

        return $this;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function getStatutRes(): ?bool
    {
        return $this->statut_res;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function setStatutRes(bool $statut_res): self
    {
        $this->statut_res = $statut_res;

        return $this;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function getAgence(): ?Agence
    {
        return $this->agence;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function setAgence(?Agence $agence): self
    {
        $this->agence = $agence;

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
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

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

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function addContrat(Contrat $contrat): self
    {
        if (!$this->contrats->contains($contrat)) {
            $this->contrats[] = $contrat;
            $contrat->setReservation($this);
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
            if ($contrat->getReservation() === $this) {
                $contrat->setReservation(null);
            }
        }

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
    public function setContrat(Contrat $contrat): self
    {
        $this->contrat = $contrat;

        // set the owning side of the relation if necessary
        if ($this !== $contrat->getReservation()) {
            $contrat->setReservation($this);
        }

        return $this;
    }

    public function denyAccessUnlessGranted(string $string)
    {
    }

    public function getToutPaye(): ?bool
    {
        return $this->toutPaye;
    }

    public function setToutPaye(bool $toutPaye): self
    {
        $this->toutPaye = $toutPaye;

        return $this;
    }

    public function getAgenceRetour(): ?string
    {
        return $this->agence_retour;
    }

    public function setAgenceRetour(string $agence_retour): self
    {
        $this->agence_retour = $agence_retour;

        return $this;
    }

    public function getCouvertureDommage(): ?int
    {
        return $this->couverture_dommage;
    }

    public function setCouvertureDommage(?int $couverture_dommage): self
    {
        $this->couverture_dommage = $couverture_dommage;

        return $this;
    }

    public function getCouvertureVol(): ?int
    {
        return $this->couverture_vol;
    }

    public function setCouvertureVol(?int $couverture_vol): self
    {
        $this->couverture_vol = $couverture_vol;

        return $this;
    }

    public function getTrancheAge(): ?int
    {
        return $this->tranche_age;
    }

    public function setTrancheAge(?int $tranche_age): self
    {
        $this->tranche_age = $tranche_age;

        return $this;
    }
}
