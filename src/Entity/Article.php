<?php
namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $datePublication = null;

    // Modification de "auteur" en "auteur_id" pour stocker un integer
    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $auteur_id = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $picture = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDatePublication(): ?\DateTimeInterface
    {
        return $this->datePublication;
    }

    public function setDatePublication(): self
    {
        $this->datePublication = new \DateTimeImmutable();
        return $this;
    }

    // Accesseur pour "auteur_id" (le nouvel ID de l'auteur)
    public function getAuteurId(): ?int
    {
        return $this->auteur_id;
    }

    // Modificateur pour "auteur_id"
    public function setAuteurId(int $auteur_id): static
    {
        $this->auteur_id = $auteur_id;

        return $this;
    }

    public function getPicture()
    {
        return $this->picture;
    }

    public function setPicture($picture): static
    {
        // Si l'image est téléchargée en tant qu'objet File, la convertir en binaire
        if ($picture instanceof \Symfony\Component\HttpFoundation\File\UploadedFile) {
            $this->picture = file_get_contents($picture->getPathname());  // Lire le contenu du fichier
        }
        return $this;
    }
}
