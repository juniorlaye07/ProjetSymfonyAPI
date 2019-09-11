<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\TransactionRepository")
 */
class Transaction
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"listTransac"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"listTransac"})
     */
    private $nomE;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"listTransac"})
     */
    private $prenomE;

    /**
     * @ORM\Column(name="cniE",type="string", length=255, unique=true)
     * @Assert\NotBlank(message="Vous devez insérer un numero valide")
     * @Assert\Regex(
     *     pattern="/^(\+[1-9][0-9]*(\([0-9]*\)|-[0-9]*-))?[0]?[1-9][0-9\-]*$/",
     *     match=true,
     *     message="Votre numero ne doit pas contenir de lettre"
     * )
     * @Groups({"listTransac"})
     */
    private $cniE;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"listTransac"})
     */
    private $nomB;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"listTransac"})
     */
    private $prenomB;
    /**
     * @ORM\Column(name="cniB",type="string", length=255, unique=true)
     * @Assert\NotBlank(message="Vous devez insérer un numero valide")
     * @Assert\Regex(
     *     pattern="/^([1-9][0-9]*(\([0-9]*\)|-[0-9]*-))?[0]?[1-9][0-9\-]*$/",
     *     match=true,
     *     message="Votre numero ne doit pas contenir de lettre"
     * )
     * @Groups({"listTransac"})
     */
    private $cniB;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"listTransac"})
     */
    private $dateTrans;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"listTransac"})
     */
    private $envoi;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"listTransac"})
     */
    private $retrait;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="transactions")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"listTransac"})
     */
    private $user;

    /**
     * @ORM\Column(name="telephoneE",type="string", length=255, unique=true)
     * @Assert\NotBlank(message="Vous devez insérer un téléphone")
     * @Assert\Regex(
     *     pattern="/^(\+[1-9][0-9]*(\([0-9]*\)|-[0-9]*-))?[0]?[1-9][0-9\-]*$/",
     *     match=true,
     *     message="Votre numero ne doit pas contenir de lettre"
     * )
     * @Groups({"listTransac"})
     */
    private $telephoneE;

    /**
     * @ORM\Column(name="telephoneB",type="string", length=255, unique=true, nullable=true)
     * @Assert\NotBlank(message="Vous devez insérer un téléphone")
     * @Assert\Regex(
     *     pattern="/^(\+[1-9][0-9]*(\([0-9]*\)|-[0-9]*-))?[0]?[1-9][0-9\-]*$/",
     *     match=true,
     *     message="Votre numero ne doit pas contenir de lettre"
     * )
     * @Groups({"listTransac"})
     */
    private $telephoneB;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"listTransac"})
     */
    private $montant;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"listTransac"})
     */
    private $montantpaye;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"listTransac"})
     */
    private $codeTrans;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomE(): ?string
    {
        return $this->nomE;
    }

    public function setNomE(?string $nomE): self
    {
        $this->nomE = $nomE;

        return $this;
    }

    public function getPrenomE(): ?string
    {
        return $this->prenomE;
    }

    public function setPrenomE(?string $prenomE): self
    {
        $this->prenomE = $prenomE;

        return $this;
    }

    public function getCniE(): ?string
    {
        return $this->cniE;
    }

    public function setCniE(?string $cniE): self
    {
        $this->cniE = $cniE;

        return $this;
    }

    public function getNomB(): ?string
    {
        return $this->nomB;
    }

    public function setNomB(?string $nomB): self
    {
        $this->nomB = $nomB;

        return $this;
    }

    public function getPrenomB(): ?string
    {
        return $this->prenomB;
    }

    public function setPrenomB(?string $prenomB): self
    {
        $this->prenomB = $prenomB;

        return $this;
    }

    public function getCniB(): ?string
    {
        return $this->cniB;
    }

    public function setCniB(?string $cniB): self
    {
        $this->cniB = $cniB;

        return $this;
    }

    public function getDateTrans(): ?\DateTimeInterface
    {
        return $this->dateTrans;
    }

    public function setDateTrans(\DateTimeInterface $dateTrans): self
    {
        $this->dateTrans = $dateTrans;

        return $this;
    }

    public function getEnvoi(): ?string
    {
        return $this->envoi;
    }

    public function setEnvoi(?string $envoi): self
    {
        $this->envoi = $envoi;

        return $this;
    }

    public function getRetrait(): ?string
    {
        return $this->retrait;
    }

    public function setRetrait(?string $retrait): self
    {
        $this->retrait = $retrait;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getTelephoneE(): ?string
    {
        return $this->telephoneE;
    }

    public function setTelephoneE(?string $telephoneE): self
    {
        $this->telephoneE = $telephoneE;

        return $this;
    }

    public function getTelephoneB(): ?string
    {
        return $this->telephoneB;
    }

    public function setTelephoneB(string $telephoneB): self
    {
        $this->telephoneB = $telephoneB;

        return $this;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(?int $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getMontantpaye(): ?int
    {
        return $this->montantpaye;
    }

    public function setMontantpaye(?int $montantpaye): self
    {
        $this->montantpaye = $montantpaye;

        return $this;
    }

    public function getCodeTrans(): ?string
    {
        return $this->codeTrans;
    }

    public function setCodeTrans(?string $codeTrans): self
    {
        $this->codeTrans = $codeTrans;

        return $this;
    }
}
