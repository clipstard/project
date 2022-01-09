<?php

namespace App\Controller;

use App\Entity\Notification;
use App\Repository\NotificationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class ReadNotificationController extends AbstractController
{
    /** @var EntityManagerInterface */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function __invoke(Request $request)
    {
        $id = $request->get('id');
        /**
         * @var NotificationRepository
         */
        $repos = $this->em->getRepository(Notification::class);
        /** @var Notification $notif */
        $notif = $repos->findOneBy(['id' => $id]);
        $notif->setRead(true);

        $this->em->persist($notif);
        $this->em->flush();

        return $notif;
    }
}
