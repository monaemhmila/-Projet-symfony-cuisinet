<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ProduitRepository::class)
 */
class Produit
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("post:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le nom du produit est obligatoire.")
     * @Assert\Length(
     * min = "3",
     * max = "10",
     * minMessage = "Le nom du produit doit faire au moins {{ limit }} caractères",
     * maxMessage = "Le nom du produit ne peut pas être plus long que {{ limit }} caractères"
     * )
     * @Groups("post:read")

     */


    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le description du produit est obligatoire.")
     * @Assert\Length(
     * min = "5",
     * max = "50",
     * minMessage = "Le description du produit doit faire au moins {{ limit }} caractères",
     * maxMessage = "Le description du produit ne peut pas être plus long que {{ limit }} caractères"
     * )
     * @Groups("post:read")

     */
    private $description;

    /**
     * @ORM\Column(type="float")
     * @Assert\GreaterThan(0)
     * @Groups("post:read")

     */
    private $prix;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("post:read")
     */
    private $photo;

    /**
     * @ORM\OneToMany(targetEntity=Promotion::class, mappedBy="produit", cascade={"all"}, orphanRemoval=true)

     */
    private $promotions;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("post:read")
     */
    private $type;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix (float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto( $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
}

