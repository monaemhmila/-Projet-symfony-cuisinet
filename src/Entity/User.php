<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le nom d'utilisateur est obligatoire.")
     * @Assert\Length(
     * min = "3",
     * max = "32",
     * minMessage = "Le nom d'utilisateur doit faire au moins {{ limit }} caractères",
     * maxMessage = "Le nom d'utilisateur ne peut pas être plus long que {{ limit }} caractères"
     * )
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le mot de passe est obligatoire.")
     * @Assert\Length(
     * min = "8",
     * max = "40",
     * minMessage = "Le mot de passe doit faire au moins {{ limit }} caractères",
     * maxMessage = "Le mot de passe ne peut pas être plus long que {{ limit }} caractères"
     * )
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le champ nom/prenom est obligatoire.")
     * @Assert\Length(
     * min = "8",
     * max = "40",
     * minMessage = "Le champ nom/prenom doit faire au moins {{ limit }} caractères",
     * maxMessage = "Le champ nom/prenom ne peut pas être plus long que {{ limit }} caractères"
     * )
     */
    private $fullname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $role;

    /**
     * @ORM\Column(type="string", length=255, options={"default": ""})
     * @Assert\NotBlank(message="Le champ avatar est obligatoire.")
     */
    private $avatar;

    /**
     * @ORM\Column(type="boolean", options={"default": "false"}, nullable="true")
     */
    private $isBanned;

    /**
     * @ORM\Column(type="boolean", options={"default": "false"}, nullable="true")
     */
    private $isActivated;

    /**
     * @ORM\Column(type="string", length=255, options={"default": ""}, nullable="true")
     */
    private $activationCode;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(string $fullname): self
    {
        $this->fullname = $fullname;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    public function setAvatar($avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getIsBanned(): ?bool
    {
        return $this->isBanned;
    }

    public function setIsBanned(bool $isBanned): self
    {
        $this->isBanned = $isBanned;

        return $this;
    }

    public function getIsActivated(): ?bool
    {
        return $this->isActivated;
    }

    public function setIsActivated(bool $isActivated): self
    {
        $this->isActivated = $isActivated;

        return $this;
    }

    public function getActivationCode(): ?string
    {
        return $this->activationCode;
    }

    public function setActivationCode(?string $activationCode): self
    {
        $this->activationCode = $activationCode;

        return $this;
    }
}
