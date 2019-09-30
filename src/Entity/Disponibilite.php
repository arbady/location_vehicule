<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Onurb\Doctrine\ORMMetadataGrapher\Mapping as Grapher;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DisponibiliteRepository")
 * @Grapher\Color("khaki")
 */
class Disponibilite
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
    private $date_dispo;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Agence", inversedBy="disponibilites")
     * @ORM\JoinColumn(nullable=false)
     */
    private $agence;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Vehicule", inversedBy="disponibilites")
     * @ORM\JoinColumn(nullable=false)
     */
    private $vehicule;

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
    public function getDateDispo(): ?\DateTimeInterface
    {
        return $this->date_dispo;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function setDateDispo(\DateTimeInterface $date_dispo): self
    {
        $this->date_dispo = $date_dispo;

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
    public function getVehicule(): ?Vehicule
    {
        return $this->vehicule;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function setVehicule(?Vehicule $vehicule): self
    {
        $this->vehicule = $vehicule;

        return $this;
    }
}
