<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Onurb\Doctrine\ORMMetadataGrapher\Mapping as Grapher;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FactureRepository")
 * @Grapher\Color("khaki")
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
     * @Assert\NotBlank(message="vide")
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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ModeDePaiement", mappedBy="facture")
     */
    private $mode_paiement;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Contrat", inversedBy="facture", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $contrat;

    public function __construct()
    {
        $this->mode_paiement = new ArrayCollection();
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
    public function getNumFacture(): ?int
    {
        return $this->num_facture;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function setNumFacture(int $num_facture): self
    {
        $this->num_facture = $num_facture;

        return $this;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function getDateFacture(): ?\DateTimeInterface
    {
        return $this->date_facture;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function setDateFacture(\DateTimeInterface $date_facture): self
    {
        $this->date_facture = $date_facture;

        return $this;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function getMontantTotalHtva(): ?float
    {
        return $this->montant_total_htva;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function setMontantTotalHtva(float $montant_total_htva): self
    {
        $this->montant_total_htva = $montant_total_htva;

        return $this;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function getMontantTotalTva(): ?float
    {
        return $this->montant_total_tva;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function setMontantTotalTva(float $montant_total_tva): self
    {
        $this->montant_total_tva = $montant_total_tva;

        return $this;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function getPaye(): ?bool
    {
        return $this->paye;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function setPaye(bool $paye): self
    {
        $this->paye = $paye;

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

        return $this;
    }

    /**
     * @return Collection|ModeDePaiement[]
     * @Grapher\IsDisplayedMethod()
     */
    public function getModePaiement(): Collection
    {
        return $this->mode_paiement;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function addModePaiement(ModeDePaiement $modePaiement): self
    {
        if (!$this->mode_paiement->contains($modePaiement)) {
            $this->mode_paiement[] = $modePaiement;
            $modePaiement->setFacture($this);
        }

        return $this;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function removeModePaiement(ModeDePaiement $modePaiement): self
    {
        if ($this->mode_paiement->contains($modePaiement)) {
            $this->mode_paiement->removeElement($modePaiement);
            // set the owning side to null (unless already changed)
            if ($modePaiement->getFacture() === $this) {
                $modePaiement->setFacture(null);
            }
        }

        return $this;
    }
}
