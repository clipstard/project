<?php
namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use App\Controller\NotificationController;
use App\Controller\ReadNotificationController;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NotificationRepository")
 */
#[ApiResource(
    collectionOperations: [
        'get',
        'get_for_user' => [
            'method' => 'GET',
            'path' => '/notifications/{id}',
            'normalization_context' => ['groups' => 'get_notifications'],
            'controller' => NotificationController::class,
            'read' => true,
        ],
        'put',
        'read_notification' => [
            'method' => 'PUT',
            'path' => '/notifications/{id}',
            'normalization_context' => ['groups' => 'get_notifications'],
            'controller' => ReadNotificationController::class,
            'read' => true,
            'write' => true,
        ],
    ]
)]
class Notification
{
    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    #[ApiProperty(identifier: true)]
    #[Groups(['get_notifications'])]
    public int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['get_notifications'])]
    public string $name;

    /**
     * @ORM\Column(type="boolean", options={"default": "0"}, name="is_read")
     */
    #[Groups(['get_notifications'])]
    public bool $read = false;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(nullable=false, name="target_user_id")
     */
    #[ApiProperty(readableLink: true, writableLink: true, iri: true)]
    #[Groups(['get_notifications'])]
    protected User $target;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    #[Gedmo\Timestampable(on: 'create')]
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['get_notifications'])]
    protected $createdAt;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    #[Gedmo\Timestampable(on: 'update')]
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['get_notifications'])]
    protected $updatedAt;

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

    /**
     * @param bool $read
     *
     * @return Notification
     */
    public function setRead(bool $read): self
    {
        $this->read = $read;

        return $this;
    }

    /**
     * @return bool
     */
    public function isRead(): bool
    {
        return $this->read;
    }

    /**
     * @return User
     */
    public function getTarget(): User
    {
        return $this->target;
    }

    /**
     * @param User $target
     *
     * @return Notification
     */
    public function setTarget(User $target): self
    {
        $this->target = $target;

        return $this;
    }
}
