<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Onurb\Doctrine\ORMMetadataGrapher\Mapping as Grapher;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PermisRepository")
 * @Grapher\Color("khaki")
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

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function getCategoriePermis(): ?string
    {
        return $this->categorie_permis;
    }

    /**
     * @Grapher\IsDisplayedMethod()
     */
    public function setCategoriePermis(string $categorie_permis): self
    {
        $this->categorie_permis = $categorie_permis;

        return $this;
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
    public function  __toString()
    {
        return  $this->categorie_permis;
    }
}
