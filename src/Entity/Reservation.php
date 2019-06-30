<?php

namespace App\Entity;

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
     * @ORM\Column(type="time")
     */
    private $heure_debut_loc;

    /**
     * @ORM\Column(type="time")
     */
    private $heure_fin_loc;

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

    public function getHeureDebutLoc(): ?\DateTimeInterface
    {
        return $this->heure_debut_loc;
    }

    public function setHeureDebutLoc(\DateTimeInterface $heure_debut_loc): self
    {
        $this->heure_debut_loc = $heure_debut_loc;

        return $this;
    }

    public function getHeureFinLoc(): ?\DateTimeInterface
    {
        return $this->heure_fin_loc;
    }

    public function setHeureFinLoc(\DateTimeInterface $heure_fin_loc): self
    {
        $this->heure_fin_loc = $heure_fin_loc;

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
}
