<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class HomeController extends AbstractController
{

    /** @Route(name="home", path="/home")  */
    public function __invoke()
    {
        $em = $this->getDoctrine()->getManager();
        /** @var ProductRepository $repo */
        $repo = $em->getRepository(Product::class);
        $repo->findAll();
        return new JsonResponse(['succes'=> true]);
    }
}