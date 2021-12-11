<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductController extends AbstractController
{

    /** @Route(name="products", path="/products", methods={"GET"})  */
    public function getAll(): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        /** @var ProductRepository $repo */
        $repo = $em->getRepository(Product::class);
        return new JsonResponse($repo->findBy(['updated_by' => 'me']));
    }

    /** @Route(name="createProduct", path="/products", methods={"POST"})  */
    public function create(Request $request): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();

        $content = json_decode($request->getContent(), true);
        $product = (new Product())
            ->setName($content['name'])
            ->setPrice($content['price'])
            ->setUpdatedBy($content['updated_by']);

        $em->persist($product);
        $em->flush();

        return new JsonResponse($product);
    }

    /** @Route(name="updateProduct", path="/products", methods={"PUT"})  */
    public function update(Request $request): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();

        $content = json_decode($request->getContent(), true);
        $product = $em->find(Product::class, $content['id']);
        $product->setName($content['name'])
            ->setPrice($content['price'])
            ->setUpdatedBy($content['updated_by']);

        $em->persist($product);
        $em->flush();

        return new JsonResponse($product);
    }
}
