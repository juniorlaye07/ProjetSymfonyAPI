<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\TarifsRepository")
 */
class Tarifs
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
    private $BorneInf;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $BorneSup;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Valeurs;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBorneInf(): ?string
    {
        return $this->BorneInf;
    }

    public function setBorneInf(string $BorneInf): self
    {
        $this->BorneInf = $BorneInf;

        return $this;
    }

    public function getBorneSup(): ?string
    {
        return $this->BorneSup;
    }

    public function setBorneSup(string $BorneSup): self
    {
        $this->BorneSup = $BorneSup;

        return $this;
    }

    public function getValeurs(): ?string
    {
        return $this->Valeurs;
    }

    public function setValeurs(string $Valeurs): self
    {
        $this->Valeurs = $Valeurs;

        return $this;
    }
}
