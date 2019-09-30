<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Onurb\Doctrine\ORMMetadataGrapher\Mapping as Grapher;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ModeDePaiementRepository")
 * @Grapher\Color("khaki")
 */
class ModeDePaiement
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Facture", inversedBy="mode_paiement")
     * @ORM\JoinColumn(nullable=false)
     */
    private $facture;

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
    public function getFacture(): ?Facture
    {
        return $this->facture;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function setFacture(?Facture $facture): self
    {
        $this->facture = $facture;

        return $this;
    }
}
