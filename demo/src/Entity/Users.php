<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 *
 * @ORM\Table(name="users")
 * @ORM\Entity
 */
class Users
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255, nullable=false)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="fullname", type="string", length=255, nullable=false, options={"default"="'Foo Bar'"})
     */
    private $fullname = '\'Foo Bar\'';

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=200, nullable=false)
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(name="role", type="string", length=100, nullable=true, options={"default"="'Normal'"})
     */
    private $role = '\'Normal\'';

    /**
     * @var string
     *
     * @ORM\Column(name="avatar", type="string", length=255, nullable=false, options={"default"="'default.jpg'"})
     */
    private $avatar = '\'default.jpg\'';

    /**
     * @var int
     *
     * @ORM\Column(name="isBanned", type="integer", nullable=false)
     */
    private $isbanned = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="isActivated", type="integer", nullable=false)
     */
    private $isactivated = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="activationCode", type="string", length=100, nullable=false, options={"default"="''"})
     */
    private $activationcode = '\'\'';

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(?string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getIsbanned(): ?int
    {
        return $this->isbanned;
    }

    public function setIsbanned(int $isbanned): self
    {
        $this->isbanned = $isbanned;

        return $this;
    }

    public function getIsactivated(): ?int
    {
        return $this->isactivated;
    }

    public function setIsactivated(int $isactivated): self
    {
        $this->isactivated = $isactivated;

        return $this;
    }

    public function getActivationcode(): ?string
    {
        return $this->activationcode;
    }

    public function setActivationcode(string $activationcode): self
    {
        $this->activationcode = $activationcode;

        return $this;
    }


}
