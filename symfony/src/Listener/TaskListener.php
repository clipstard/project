<?php


namespace App\Listener;


use App\Entity\Professor;
use App\Entity\Task;
use App\Entity\User;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Constraints\DateTime;


class TaskListener implements EventSubscriber
{

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
        ];
    }

    public function prePersist(LifecycleEventArgs $event)
    {
        $entity = $event->getObject();
        if (!$entity instanceof Task) {
            return;
        }

//        $entity->setCreatedAt(new \DateTime());
//        $entity->setUpdatedAt(new \DateTime());
//        dump($entity); die;

        /**
         * @var Professor $user
         */
        $user = $this->security->getUser();
//        $event->getEntityManager()->commit(); die;
//        $professor = (new Professor())
//            ->setPassword($user->getPassword())
//            ->setPlainPassword(null)
//            ->setName($user->getName())
//            ->setEmail('professor@mail.me');

        $entity->setCreatedBy($user);
//        $event->getEntityManager()->persist($entity);
    }

}
