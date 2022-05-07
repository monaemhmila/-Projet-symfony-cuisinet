<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 *
 * @ORM\Table(name="commande")
 * @ORM\Entity
 */
class Commande
{
    /**
     * @var int
     *
     * @ORM\Column(name="idcom", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcom;

    /**
     * @var string
     *
     * @ORM\Column(name="etatcom", type="string", length=255, nullable=false)
     */
    private $etatcom;

    /**
     * @var string
     *
     * @ORM\Column(name="datecom", type="string", length=255, nullable=false)
     */
    private $datecom;

    /**
     * @var string
     *
     * @ORM\Column(name="gendercom", type="string", length=255, nullable=false)
     */
    private $gendercom;

    /**
     * @var string
     *
     * @ORM\Column(name="descrom", type="string", length=255, nullable=false)
     */
    private $descrom;

    public function getIdcom(): ?int
    {
        return $this->idcom;
    }

    public function getEtatcom(): ?string
    {
        return $this->etatcom;
    }

    public function setEtatcom(string $etatcom): self
    {
        $this->etatcom = $etatcom;

        return $this;
    }

    public function getDatecom(): ?string
    {
        return $this->datecom;
    }

    public function setDatecom(string $datecom): self
    {
        $this->datecom = $datecom;

        return $this;
    }

    public function getGendercom(): ?string
    {
        return $this->gendercom;
    }

    public function setGendercom(string $gendercom): self
    {
        $this->gendercom = $gendercom;

        return $this;
    }

    public function getDescrom(): ?string
    {
        return $this->descrom;
    }

    public function setDescrom(string $descrom): self
    {
        $this->descrom = $descrom;

        return $this;
    }


}
