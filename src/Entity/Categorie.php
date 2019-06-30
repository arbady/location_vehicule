<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategorieRepository")
 */
class Categorie
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
    private $type_cat;

    /**
     * @ORM\Column(type="float")
     */
    private $cout_par_jour;

    /**
     * @ORM\Column(type="integer")
     */
    private $reserve_de_vehicule_disponible;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeCat(): ?string
    {
        return $this->type_cat;
    }

    public function setTypeCat(string $type_cat): self
    {
        $this->type_cat = $type_cat;

        return $this;
    }

    public function getCoutParJour(): ?float
    {
        return $this->cout_par_jour;
    }

    public function setCoutParJour(float $cout_par_jour): self
    {
        $this->cout_par_jour = $cout_par_jour;

        return $this;
    }

    public function getReserveDeVehiculeDisponible(): ?int
    {
        return $this->reserve_de_vehicule_disponible;
    }

    public function setReserveDeVehiculeDisponible(int $reserve_de_vehicule_disponible): self
    {
        $this->reserve_de_vehicule_disponible = $reserve_de_vehicule_disponible;

        return $this;
    }
}
