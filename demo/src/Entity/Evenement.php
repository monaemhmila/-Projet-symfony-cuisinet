<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Evenement
 *
 * @ORM\Table(name="evenement")
 * @ORM\Entity
 */
class Evenement
{
    /**
     * @var int
     *
     * @ORM\Column(name="ideven", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ideven;

    /**
     * @var int
     *
     * @ORM\Column(name="idspon", type="integer", nullable=false)
     */
    private $idspon;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="desceven", type="string", length=255, nullable=false)
     */
    private $desceven;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255, nullable=false)
     */
    private $adresse;

    public function getIdeven(): ?int
    {
        return $this->ideven;
    }

    public function getIdspon(): ?int
    {
        return $this->idspon;
    }

    public function setIdspon(int $idspon): self
    {
        $this->idspon = $idspon;

        return $this;
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

    public function getDesceven(): ?string
    {
        return $this->desceven;
    }

    public function setDesceven(string $desceven): self
    {
        $this->desceven = $desceven;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }


}
