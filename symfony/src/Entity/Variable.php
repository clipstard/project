<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VariableRepository")
 * @ORM\Table(name="variable_table")
 */
#[ApiResource(
    normalizationContext:  ['groups' => ['get', 'put', 'post']],
)]
class Variable
{
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
     * @var string
     * @ORM\Column(type="string", length=255, name="type_col")
     */
    #[Groups(["get", "post", "put"])]
    protected string $type;

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
    public function getName(): string
    {
        return $this->name;
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
}
