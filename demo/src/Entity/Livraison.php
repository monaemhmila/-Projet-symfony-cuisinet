<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Livraison
 *
 * @ORM\Table(name="livraison")
 * @ORM\Entity
 */
class Livraison
{
    /**
     * @var int
     *
     * @ORM\Column(name="idliv", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idliv;

    /**
     * @var int
     *
     * @ORM\Column(name="idcom", type="integer", nullable=false)
     */
    private $idcom;

    /**
     * @var string
     *
     * @ORM\Column(name="livreur", type="string", length=255, nullable=false)
     */
    private $livreur;

    /**
     * @var string
     *
     * @ORM\Column(name="descliv", type="string", length=255, nullable=false)
     */
    private $descliv;

    public function getIdliv(): ?int
    {
        return $this->idliv;
    }

    public function getIdcom(): ?int
    {
        return $this->idcom;
    }

    public function setIdcom(int $idcom): self
    {
        $this->idcom = $idcom;

        return $this;
    }

    public function getLivreur(): ?string
    {
        return $this->livreur;
    }

    public function setLivreur(string $livreur): self
    {
        $this->livreur = $livreur;

        return $this;
    }

    public function getDescliv(): ?string
    {
        return $this->descliv;
    }

    public function setDescliv(string $descliv): self
    {
        $this->descliv = $descliv;

        return $this;
    }


}
