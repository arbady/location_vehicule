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
     * @ORM\Column(type="string", length=2)
     */
    private $categorie_permis;

    public function getCategoriePermis(): ?string
    {
        return $this->categorie_permis;
    }

    public function setCategoriePermis(string $categorie_permis): self
    {
        $this->categorie_permis = $categorie_permis;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function  __toString()
    {
        return  $this->categorie_permis;
    }
}
