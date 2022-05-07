<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sponsor
 *
 * @ORM\Table(name="sponsor")
 * @ORM\Entity
 */
class Sponsor
{
    /**
     * @var int
     *
     * @ORM\Column(name="idspon", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idspon;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var int
     *
     * @ORM\Column(name="telspon", type="integer", nullable=false)
     */
    private $telspon;

    /**
     * @var string
     *
     * @ORM\Column(name="descspon", type="string", length=255, nullable=false)
     */
    private $descspon;

    public function getIdspon(): ?int
    {
        return $this->idspon;
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

    public function getTelspon(): ?int
    {
        return $this->telspon;
    }

    public function setTelspon(int $telspon): self
    {
        $this->telspon = $telspon;

        return $this;
    }

    public function getDescspon(): ?string
    {
        return $this->descspon;
    }

    public function setDescspon(string $descspon): self
    {
        $this->descspon = $descspon;

        return $this;
    }


}
