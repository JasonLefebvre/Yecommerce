<?php

namespace App\Entity;

use App\Repository\InvoiceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InvoiceRepository::class)]
class Invoice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: "integer")]
    private ?int $user_id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_transaction = null;

    #[ORM\Column]
    private ?float $montant = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse_facturation = null;

    #[ORM\Column(length: 100)]
    private ?string $ville_facturation = null;

    #[ORM\Column(length: 10)]
    private ?string $code_postal_facturation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): static
    {
        $this->user_id = $user_id;
        return $this;
    }

    public function getDateTransaction(): ?\DateTimeInterface
    {
        return $this->date_transaction;
    }

    public function setDateTransaction(\DateTimeInterface $date_transaction): static
    {
        $this->date_transaction = $date_transaction;
        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): static
    {
        $this->montant = $montant;
        return $this;
    }

    public function getAdresseFacturation(): ?string
    {
        return $this->adresse_facturation;
    }

    public function setAdresseFacturation(string $adresse_facturation): static
    {
        $this->adresse_facturation = $adresse_facturation;
        return $this;
    }

    public function getVilleFacturation(): ?string
    {
        return $this->ville_facturation;
    }

    public function setVilleFacturation(string $ville_facturation): static
    {
        $this->ville_facturation = $ville_facturation;
        return $this;
    }

    public function getCodePostalFacturation(): ?string
    {
        return $this->code_postal_facturation;
    }

    public function setCodePostalFacturation(string $code_postal_facturation): static
    {
        $this->code_postal_facturation = $code_postal_facturation;
        return $this;
    }
}
