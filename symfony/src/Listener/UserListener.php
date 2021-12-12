<?php

namespace App\Listener;


use App\Entity\Group;
use App\Entity\Student;
use App\Entity\User;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserListener implements EventSubscriber
{

    /** @var UserPasswordHasherInterface */
    private UserPasswordHasherInterface $passwordEncoder;

    public function __construct(UserPasswordHasherInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof User)
            return;

        if ($entity instanceof Student) {
            $this->appendGroup($args);
        }


        $this->encodePassword($entity);
    }

    public function appendGroup(LifecycleEventArgs $args)
    {
        $em = $args->getEntityManager();
        $repo = $em->getRepository(Group::class);
        $group = $repo->findOneBy(['name' => 'Unknown']);
        /**
         * @var Student $student
         */
        $student = $args->getEntity();

        if (null === $group) {
            $group = (new Group())->setName('Unknown')
                ->addStudent($student);
            $em->persist($group);
        }

        $group->addStudent($student);
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();


        if (!$entity instanceof User)
            return;

        $this->encodePassword($entity);

        // necessary to force the update to see the change
        $em = $args->getEntityManager();
        $meta = $em->getClassMetadata(get_class($entity));
        $em->getUnitOfWork()->recomputeSingleEntityChangeSet($meta, $entity);
    }

    public function getSubscribedEvents()
    {
        return [
            Events::preUpdate,
            Events::prePersist,
        ];
    }

    private function encodePassword(User $entity)
    {
        if (!$entity->getPlainPassword())
            return;

        $encoded = $this->passwordEncoder->hashPassword($entity, $entity->getPlainPassword());
        $entity->setPassword($encoded);
    }
}
