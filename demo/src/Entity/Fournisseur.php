<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fournisseur
 *
 * @ORM\Table(name="fournisseur")
 * @ORM\Entity
 */
class Fournisseur
{
    /**
     * @var int
     *
     * @ORM\Column(name="idfor", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idfor;

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
     * @ORM\Column(name="tel", type="integer", nullable=false)
     * @Assert\NotNull (message="vous devez saisir un numero telephone ") 
     */
    private $tel;

    /**
     * @var string
     *
     * @ORM\Column(name="descfor", type="string", length=255, nullable=false)
     * @Assert\NotNull (message="vous devez saisir la description ") 
     */
    private $descfor;

    public function getIdfor(): ?int
    {
        return $this->idfor;
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

    public function getTel(): ?int
    {
        return $this->tel;
    }

    public function setTel(int $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getDescfor(): ?string
    {
        return $this->descfor;
    }

    public function setDescfor(string $descfor): self
    {
        $this->descfor = $descfor;

        return $this;
    }

    public function __toString()
    {
        return $this->nom;
    }








}
