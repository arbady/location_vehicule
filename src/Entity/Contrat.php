<?php

namespace App\Entity;

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
}
