<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Professor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class HomeController extends AbstractController
{

    /** @Route(name="home", path="/home")  */
    public function __invoke()
    {
        $admin = new Professor();
        $admin->setEmail('professor@admin.me')
            ->setName('professor')
            ->setPassword('asd')
            ->setPlainPassword('asd');

        $em = $this->getDoctrine()->getManager();
        $em->persist($admin);
        $em->flush();

        return new JsonResponse(['succes'=> true]);
    }
}
