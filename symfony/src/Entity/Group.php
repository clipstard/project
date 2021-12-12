<?php
namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GroupRepository")
 * @ORM\Table(name="group_table")
 */
#[ApiResource(
    normalizationContext:  ['groups' => ['get', 'put', 'post']],
)]
class Group
{

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
     * @var Collection|array
     * @ORM\OneToMany(targetEntity="Student", mappedBy="group")
     */
    protected Collection|array $students;

    /**
     * @var Collection|Task[]
     * @ORM\ManyToMany(targetEntity="Task", mappedBy="groups")
     */
    #[ApiSubresource]
    protected Collection|array $assignedTasks;

    public function __construct()
    {
        $this->assignedTasks = new ArrayCollection();
        $this->students = new ArrayCollection();
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Group
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
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
     *
     * @return Group
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
            $task->addGroup($this);
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
            $task->removeGroup($this);
        }

        return $this;
    }

    /**
     * @return array|Collection
     */
    public function getStudents(): Collection|array
    {
        return $this->students;
    }

    /**
     * @param array|Collection $students
     *
     * @return Group
     */
    public function setStudents(Collection|array $students): self
    {
        $this->students = $students;

        return $this;
    }

    /**
     * @param Student $student
     * @return $this
     */
    public function addStudent(Student $student): self
    {
        if (!$this->students->contains($student)) {
            $this->students->add($student);
            $student->setGroup($this);
        }

        return $this;
    }

    /**
     * @param Student $student
     * @return $this
     */
    public function removeStudent(Student $student): self
    {
        if ($this->students->contains($student)) {
            $this->students->removeElement($student);
            $student->setGroup(null);
        }

        return $this;
    }
}
