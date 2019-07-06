<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PermisRepository")
 */
class Permis
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
    private $date_debut_permis;

    /**
     * @ORM\Column(type="date")
     */
    private $date_fin_permis;

    /**
     * @ORM\Column(type="integer")
     */
    private $num_permis;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $categorie_permis;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebutPermis(): ?\DateTimeInterface
    {
        return $this->date_debut_permis;
    }

    public function setDateDebutPermis(\DateTimeInterface $date_debut_permis): self
    {
        $this->date_debut_permis = $date_debut_permis;

        return $this;
    }

    public function getDateFinPermis(): ?\DateTimeInterface
    {
        return $this->date_fin_permis;
    }

    public function setDateFinPermis(\DateTimeInterface $date_fin_permis): self
    {
        $this->date_fin_permis = $date_fin_permis;

        return $this;
    }

    public function getNumPermis(): ?int
    {
        return $this->num_permis;
    }

    public function setNumPermis(int $num_permis): self
    {
        $this->num_permis = $num_permis;

        return $this;
    }

    public function getCategoriePermis(): ?string
    {
        return $this->categorie_permis;
    }

    public function setCategoriePermis(string $categorie_permis): self
    {
        $this->categorie_permis = $categorie_permis;

        return $this;
    }
}
