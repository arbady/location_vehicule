<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PenalisationRepository")
 */
class Penalisation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="date")
     */
    private $date_penal;

    /**
     * @ORM\Column(type="float")
     */
    private $montant_a_payer;

    /**
     * @ORM\Column(type="float")
     */
    private $montant_tot_htva;

    /**
     * @ORM\Column(type="float")
     */
    private $montant_tot_tva;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Contrat", inversedBy="penalisation", cascade={"persist", "remove"})
     */
    private $contrat;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDatePenal(): ?\DateTimeInterface
    {
        return $this->date_penal;
    }

    public function setDatePenal(\DateTimeInterface $date_penal): self
    {
        $this->date_penal = $date_penal;

        return $this;
    }

    public function getMontantAPayer(): ?float
    {
        return $this->montant_a_payer;
    }

    public function setMontantAPayer(float $montant_a_payer): self
    {
        $this->montant_a_payer = $montant_a_payer;

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

    public function getContrat(): ?Contrat
    {
        return $this->contrat;
    }

    public function setContrat(?Contrat $contrat): self
    {
        $this->contrat = $contrat;

        return $this;
    }
}
