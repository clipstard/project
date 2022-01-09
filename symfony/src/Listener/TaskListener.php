<?php


namespace App\Listener;


use App\Entity\Group;
use App\Entity\Notification;
use App\Entity\Professor;
use App\Entity\Student;
use App\Entity\Task;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\Security\Core\Security;


class TaskListener implements EventSubscriber
{
    protected $toBePersisted = [];

    protected Security $security;

    public function __construct(
        Security $security,
    )
    {
        $this->security = $security;
    }

    public function getSubscribedEvents()
    {
        return [
            Events::prePersist,
            Events::preUpdate,
            Events::postFlush,
        ];
    }

    public function prePersist(LifecycleEventArgs $event)
    {
        $entity = $event->getObject();
        if (!$entity instanceof Task) {
            return;
        }

        /**
         * @var Professor $user
         */
        $user = $this->security->getUser();

        /**
         * @var Task $entity
         */
        $entity->setCreatedBy($user);
        foreach ($entity->getAssignedTo() as $student) {
            $this->toBePersisted[] = (new Notification())->setName("A professor created task")->setTarget($student);
        }

        /**
         * @var Group $group
         */
        foreach ($entity->getGroups() as $group) {
            foreach ($group->getStudents() as $student) {
                $this->toBePersisted[] = (new Notification())->setName("A professor created task")->setTarget($student);
            }
        }
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Task)
            return;

        $user = $this->security->getUser();
        $em = $args->getEntityManager();

        if ($user instanceof Student) {
            /** @var Task $entity */
            $entity->setCompleted(true);
            $id = $entity->getId();
            $notif = (new Notification())->setName("A user completed task $id")->setTarget($entity->getCreatedBy());

            $this->toBePersisted[] = $notif;
        }

        if ($user instanceof Professor) {
            $entity->setCompleted(false);
        }
    }

    public function postFlush(PostFlushEventArgs $event)
    {
        if(!empty($this->toBePersisted)) {

            $em = $event->getEntityManager();

            foreach ($this->toBePersisted as $element) {
                $em->persist($element);
            }

            $this->toBePersisted = [];
            $em->flush();
        }
    }

}
