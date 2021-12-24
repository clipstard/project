<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 * @ORM\Table(name="task_table")
 * @ORM\HasLifecycleCallbacks()
 */
#[ApiResource(
    normalizationContext:  ['groups' => ['get', 'put', 'post', 'get_task']],
)]
class Task
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
     * @ORM\Column(type="text", name="condition_col")
     */
    #[Groups(["get", "post", "put"])]
    protected string $condition;

    /**
     * @var Collection|Variable[]
     * @ORM\ManyToMany(targetEntity="Variable")
     * @ORM\JoinTable(name="tasks_variables")
     */
    #[Groups(["get", "post", "put"])]
    protected Collection|array $variables;

    /**
     * @var Professor|null $createdBy
     * @ORM\ManyToOne(targetEntity="Professor", inversedBy="tasks")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    #[ApiSubresource]
    protected ?Professor $createdBy;

    /**
     * @var Collection|Student[] $assignedTo
     * @ORM\ManyToMany(targetEntity="Student", inversedBy="assignedTasks")
     * @ORM\JoinTable(name="students_tasks")
     */
    #[Groups(['get_task'])]
    protected Collection|array $assignedTo;

    /**
     * @var Collection|Group[] $assignedTo
     * @ORM\ManyToMany(targetEntity="Group", inversedBy="assignedTasks")
     * @ORM\JoinTable(name="groups_tasks")
     */
    #[ApiSubresource]
    #[Groups(['get_task'])]
    protected Collection|array $groups;

    /**
     * @var bool
     * @ORM\Column(type="boolean", options={"default": "0"})
     */
    #[Groups(["get", "post", "put"])]
    protected bool $isPublic;

    public function __construct()
    {
        $this->assignedTo = new ArrayCollection();
        $this->variables = new ArrayCollection();
        $this->groups = new ArrayCollection();
        $this->isPublic = false;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Student[]|Collection
     */
    public function getAssignedTo(): array|Collection
    {
        return $this->assignedTo;
    }

    /**
     * @param Student[]|Collection $assignedTo
     *
     * @return Task
     */
    public function setAssignedTo(array|Collection $assignedTo): self
    {
        $this->assignedTo = $assignedTo;

        return $this;
    }

    /**
     * @param Student $student
     * @return $this
     */
    public function addAssignedTo(Student $student): self
    {
        if (!$this->assignedTo->contains($student)) {
            $this->assignedTo->add($student);
            $student->addAssignedTask($this);
        }

        return $this;
    }

    /**
     * @param Student $student
     * @return $this
     */
    public function removeAssignedTo(Student $student): self
    {
        if ($this->assignedTo->contains($student)) {
            $this->assignedTo->removeElement($student);
            $student->removeAssignedTask($this);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getCondition(): string
    {
        return $this->condition;
    }

    /**
     * @param string $condition
     *
     * @return Task
     */
    public function setCondition(string $condition): self
    {
        $this->condition = $condition;

        return $this;
    }

    /**
     * @return Professor|null
     */
    public function getCreatedBy(): ?Professor
    {
        return $this->createdBy;
    }

    /**
     * @param Professor|null $createdBy
     *
     * @return Task
     */
    public function setCreatedBy(?Professor $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * @return Collection|Variable[]
     */
    public function getVariables(): Collection|array
    {
        return $this->variables;
    }

    /**
     * @param Collection|Variable[] $variables
     *
     * @return Task
     */
    public function setVariables(array $variables): self
    {
        $this->variables = $variables;

        return $this;
    }

    /**
     * @return Collection|Group[]
     */
    public function getGroups(): Collection|array
    {
        return $this->groups;
    }

    /**
     * @param Collection|Group[] $groups
     *
     * @return Task
     */
    public function setGroups(Collection|array $groups): self
    {
        $this->groups = $groups;

        return $this;
    }

    /**
     * @param Group $group
     * @return $this
     */
    public function addGroup(Group $group): self
    {
        if (!$this->groups->contains($group)) {
            $this->groups->add($group);
            $group->addAssignedTask($this);
        }

        return $this;
    }

    /**
     * @param Group $group
     * @return $this
     */
    public function removeGroup(Group $group): self
    {
        if ($this->groups->contains($group)) {
            $this->groups->removeElement($group);
            $group->removeAssignedTask($this);
        }

        return $this;
    }
}
