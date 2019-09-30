<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Onurb\Doctrine\ORMMetadataGrapher\Mapping as Grapher;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PenalisationRepository")
 * @Grapher\Color("khaki")
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Contrat", inversedBy="penalisations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $contrat;

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
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function getDatePenal(): ?\DateTimeInterface
    {
        return $this->date_penal;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function setDatePenal(\DateTimeInterface $date_penal): self
    {
        $this->date_penal = $date_penal;

        return $this;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function getMontantAPayer(): ?float
    {
        return $this->montant_a_payer;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function setMontantAPayer(float $montant_a_payer): self
    {
        $this->montant_a_payer = $montant_a_payer;

        return $this;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function getMontantTotHtva(): ?float
    {
        return $this->montant_tot_htva;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function setMontantTotHtva(float $montant_tot_htva): self
    {
        $this->montant_tot_htva = $montant_tot_htva;

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
}
