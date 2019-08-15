<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
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
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_trans;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Veillez bien renseigner les champs")
     * @Assert\NotBlank(message="Vous devez insérer un mot de passe")
     * @Assert\Regex(
     *     pattern="/(?=.*[a-z])(?=.*)(?=.*\d)(?=.*[#$^+=!*()@%&]).{13,}$/",
     *     match=true,
     *     message="Votre mot de passe doit contenir au moins 13 caractères"
     * )
     */
    private $CIN_en;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Veillez bien renseigner les champs")
     * @Assert\NotBlank(message="Vous devez insérer un mot de passe")
     * @Assert\Regex(
     *     pattern="/(?=.*[a-z])(?=.*)(?=.*\d)(?=.*[#$^+=!*()@%&]).{13,}$/",
     *     match=true,
     *     message="Votre mot de passe doit contenir au moins 13 caractères"
     * )
     */
    private $CIN_ben;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veillez bien renseigner les champs")
     * @Assert\NotBlank(message="Vous devez insérer un code")
     * @Assert\Regex(
     *     pattern="/(?=.*[a-z])(?=.*)(?=.*\d)(?=.*[#$^+=!*()@%&]).{9,}$/",
     *     match=true,
     *     message="Votre code doit contenir au moins 9 caractères"
     * )
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *  @Assert\NotBlank(message="Veillez bien renseigner les champs")
     */
    private $envoie;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *  @Assert\NotBlank(message="Veillez bien renseigner les champs")
     */
    private $retrait;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur", inversedBy="transactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $utilisateur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomEnvoyeur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomBeneficiaire;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Veillez bien renseigner les champs")
     * @Assert\Regex(
     *     pattern="/^(\+[1-9][0-9]*(\([0-9]*\)|-[0-9]*-))?[0]?[1-9][0-9\-]*$/",
     *     match=true,
     *     message="Votre numero de téléphone ne doit pas contenir de lettres"
     * )
     */
    private $tel_en;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Veillez bien renseigner les champs")
     * @Assert\Regex(
     *     pattern="/^(\+[1-9][0-9]*(\([0-9]*\)|-[0-9]*-))?[0]?[1-9][0-9\-]*$/",
     *     match=true,
     *     message="Votre numero de téléphone ne doit pas contenir de lettres"
     * )
     */
    private $tel_ben;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateTrans(): ?\DateTimeInterface
    {
        return $this->date_trans;
    }

    public function setDateTrans(\DateTimeInterface $date_trans): self
    {
        $this->date_trans = $date_trans;

        return $this;
    }

    public function getCINEn(): ?string
    {
        return $this->CIN_en;
    }

    public function setCINEn(?string $CIN_en): self
    {
        $this->CIN_en = $CIN_en;

        return $this;
    }

    public function getCINBen(): ?string
    {
        return $this->CIN_ben;
    }

    public function setCINBen(?string $CIN_ben): self
    {
        $this->CIN_ben = $CIN_ben;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getEnvoie(): ?string
    {
        return $this->envoie;
    }

    public function setEnvoie(?string $envoie): self
    {
        $this->envoie = $envoie;

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

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getNomEnvoyeur(): ?string
    {
        return $this->nomEnvoyeur;
    }

    public function setNomEnvoyeur(?string $nomEnvoyeur): self
    {
        $this->nomEnvoyeur = $nomEnvoyeur;

        return $this;
    }

    public function getNomBeneficiaire(): ?string
    {
        return $this->nomBeneficiaire;
    }

    public function setNomBeneficiaire(?string $nomBeneficiaire): self
    {
        $this->nomBeneficiaire = $nomBeneficiaire;

        return $this;
    }

    public function getTelEn(): ?string
    {
        return $this->tel_en;
    }

    public function setTelEn(?string $tel_en): self
    {
        $this->tel_en = $tel_en;

        return $this;
    }

    public function getTelBen(): ?string
    {
        return $this->tel_ben;
    }

    public function setTelBen(?string $tel_ben): self
    {
        $this->tel_ben = $tel_ben;

        return $this;
    }
}
