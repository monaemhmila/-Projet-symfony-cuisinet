<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Materiel
 *
 * @ORM\Table(name="materiel", indexes={@ORM\Index(name="ck_idfor", columns={"idfor"})})
 * @ORM\Entity
 */
class Materiel
{
    /**
     * @var int
     *
     * @ORM\Column(name="idmat", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idmat;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     * @Assert\NotNull (message="vous devez saisir le nom ")
     */
    private $nom;

    /**
     * @var int
     *
     * @ORM\Column(name="prix", type="integer", nullable=false)
      * @Assert\NotNull (message="vous devez saisir le prix ")
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="descmat", type="string", length=255, nullable=false)
     * @Assert\NotNull (message="vous devez saisir la description ")
     */
    private $descmat;

    /**
     * @var \Fournisseur
     *
     * @ORM\ManyToOne(targetEntity="Fournisseur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idfor", referencedColumnName="idfor")
     * })
     */
    private $idFor;

    public function getIdmat(): ?int
    {
        return $this->idmat;
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

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDescmat(): ?string
    {
        return $this->descmat;
    }

    public function setDescmat(string $descmat): self
    {
        $this->descmat = $descmat;

        return $this;
    }

    public function getIdFor(): ?Fournisseur
    {
        return $this->idFor;
    }

    public function setIdFor(?Fournisseur $idFor): self
    {
        $this->idFor = $idFor;

        return $this;
    }


}
