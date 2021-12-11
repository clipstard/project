<?php
namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProfessorRepository")
 */
#[ApiResource]
class Professor extends User
{
    /**
     * @var Task[]|Collection
     * @ORM\OneToMany(targetEntity="Task", mappedBy="createdBy")
     */
    protected Collection|array $tasks;

    public function __construct()
    {
        parent::__construct();
        $this->tasks = new ArrayCollection();
    }

    /**
     * @param Task[]|Collection $tasks
     *
     * @return Professor
     */
    public function setTasks(array|Collection $tasks): self
    {
        $this->tasks = $tasks;

        return $this;
    }

    /**
     * @return Task[]|Collection
     */
    public function getTasks(): array|Collection
    {
        return $this->tasks;
    }

    /**
     * @param Task $task
     * @return $this
     */
    public function addTask(Task $task): self
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks->add($task);
            $task->setCreatedBy($this);
        }

        return $this;
    }

    /**
     * @param Task $task
     * @return $this
     */
    public function removeTask(Task $task): self
    {
        if ($this->tasks->contains($task)) {
            $this->tasks->removeElement($task);
            $task->setCreatedBy(null);
        }

        return $this;
    }

}
