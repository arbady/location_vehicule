<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FactureRepository")
 */
class Facture
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
    private $num_facture;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\Column(type="date")
     */
    private $date_facture;

    /**
     * @ORM\Column(type="float")
     */
    private $montant_total_htva;

    /**
     * @ORM\Column(type="float")
     */
    private $montant_total_tva;

    /**
     * @ORM\Column(type="boolean")
     */
    private $paye;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumFacture(): ?int
    {
        return $this->num_facture;
    }

    public function setNumFacture(int $num_facture): self
    {
        $this->num_facture = $num_facture;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDateFacture(): ?\DateTimeInterface
    {
        return $this->date_facture;
    }

    public function setDateFacture(\DateTimeInterface $date_facture): self
    {
        $this->date_facture = $date_facture;

        return $this;
    }

    public function getMontantTotalHtva(): ?float
    {
        return $this->montant_total_htva;
    }

    public function setMontantTotalHtva(float $montant_total_htva): self
    {
        $this->montant_total_htva = $montant_total_htva;

        return $this;
    }

    public function getMontantTotalTva(): ?float
    {
        return $this->montant_total_tva;
    }

    public function setMontantTotalTva(float $montant_total_tva): self
    {
        $this->montant_total_tva = $montant_total_tva;

        return $this;
    }

    public function getPaye(): ?bool
    {
        return $this->paye;
    }

    public function setPaye(bool $paye): self
    {
        $this->paye = $paye;

        return $this;
    }
}
