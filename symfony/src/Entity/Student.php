<?php
namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StudentRepository")
 */
#[ApiResource(
    normalizationContext:  ['groups' => ['get', 'put', 'post']],
)]
class Student extends User
{

    /**
     * @var Collection|Task[]
     * @ORM\ManyToMany(targetEntity="Task", mappedBy="assignedTo")
     */
    #[Groups(["get_student"])]
    protected Collection|array $assignedTasks;

    /**
     * @var Group|null
     * @ORM\ManyToOne (targetEntity="Group", inversedBy="students")
     * @ORM\JoinColumn(referencedColumnName="id", name="group_id", onDelete="SET NULL")
     */
    #[Groups(["get", "post", "put"])]
    #[ApiSubresource]
    protected ?Group $group;

    public function __construct()
    {
        parent::__construct();
        $this->assignedTasks = [];
    }

    /**
     * @return Collection|Task[]
     */
    public function getAssignedTasks(): Collection|array
    {
        return $this->assignedTasks;
    }

    /**
     * @param Collection|Task[] $assignedTasks
     * @return $this
     */
    public function setAssignedTasks(Collection|array $assignedTasks): self
    {
        $this->assignedTasks = $assignedTasks;

        return $this;
    }

    /**
     * @param Task $task
     * @return $this
     */
    public function addAssignedTask(Task $task): self
    {
        if (!$this->assignedTasks->contains($task)) {
            $this->assignedTasks->add($task);
            $task->addAssignedTo($this);
        }

        return $this;
    }

    /**
     * @param Task $task
     * @return $this
     */
    public function removeAssignedTask(Task $task): self
    {
        if ($this->assignedTasks->contains($task)) {
            $this->assignedTasks->removeElement($task);
            $task->removeAssignedTo($this);
        }

        return $this;
    }

    /**
     * @return Group|null
     */
    public function getGroup(): ?Group
    {
        return $this->group;
    }

    /**
     * @param Group|null $group
     *
     * @return Student
     */
    public function setGroup(?Group $group): self
    {
        $this->group = $group;

        return $this;
    }
}
