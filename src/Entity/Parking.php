<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ParkingRepository")
 */
class Parking
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
    private $nb_vehicule;

    /**
     * @ORM\Column(type="boolean")
     */
    private $vehicule_dispo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbVehicule(): ?int
    {
        return $this->nb_vehicule;
    }

    public function setNbVehicule(int $nb_vehicule): self
    {
        $this->nb_vehicule = $nb_vehicule;

        return $this;
    }

    public function getVehiculeDispo(): ?bool
    {
        return $this->vehicule_dispo;
    }

    public function setVehiculeDispo(bool $vehicule_dispo): self
    {
        $this->vehicule_dispo = $vehicule_dispo;

        return $this;
    }
}
