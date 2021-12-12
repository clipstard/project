<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"Admin" = "Admin", "Student" = "Student", "Professor" = "Professor"})
 * @ORM\HasLifecycleCallbacks()
 * @method string getUserIdentifier()
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    const ADMIN = 'Admin';
    const PROFESSOR = 'Professor';
    const STUDENT = 'Student';

    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    #[Groups(["get", "post", "put"])]
    protected int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(["get", "post", "put"])]
    protected string $name;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    #[Groups(["get", "post", "put"])]
    protected string $email;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255)
     *
     */
    #[Groups(["put", "post"])]
    protected ?string $password;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    #[Gedmo\Timestampable(on: 'create')]
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(["get", "post", "put"])]
    protected $createdAt;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    #[Gedmo\Timestampable(on: 'update')]
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(["get", "post", "put"])]
    protected $updatedAt;

    #[Groups(["get", "post", "put"])]
    protected string $type;

    public function __construct()
    {
        $this->plainPassword = null;
    }

    /**
     * @var string|null
     */
    protected ?string $plainPassword;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param string $email
     *
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @param string|null $password
     *
     * @return User
     */
    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @param string|null $plainPassword
     *
     * @return User
     */
    public function setPlainPassword(?string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function getRoles()
    {
        return [];
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getSalt()
    {
        return '';
    }

    public function eraseCredentials()
    {
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function __call(string $name, array $arguments)
    {
        return $this->getUsername();
    }

    /**
     * @return string
     */
    public function getType()
    {
        if ($this instanceof Admin) {
            return self::ADMIN;
        }

        if ($this instanceof Professor) {
            return self::PROFESSOR;
        }

        return self::STUDENT;
    }
}
