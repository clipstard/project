<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Professor;
use App\Entity\Student;
use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class UserController extends AbstractController
{

    /** @Route(name="getMe", path="/api/me", methods={"GET"})  */
    public function __invoke(Security $security, NormalizerInterface $serializer)
    {
        return new JsonResponse($serializer->normalize($security->getUser(), 'json', ['groups' => 'get']), Response::HTTP_OK);
    }

    /** @Route(name="admin", path="/admin", host="*")  */
    public function getAdmin(JWTTokenManagerInterface $manager)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Admin::class);

        /**
         * @var User $admin
         */
        if (null === $admin = $repository->findOneBy(['email' => 'admin@test.me'])) {
            $admin = (new Admin())
                ->setEmail('admin@test.me')
                ->setPlainPassword('admin')
                ->setName('admin');
            $em->persist($admin);
            $em->flush();
            $em->refresh($admin);
        }

        return new JsonResponse(['token' => $manager->create($admin)], Response::HTTP_OK);
    }

    /** @Route(name="professor", path="/professor")  */
    public function getProfessor(JWTTokenManagerInterface $manager): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Professor::class);

        /**
         * @var User $admin
         */
        if (null === $admin = $repository->findOneBy(['email' => 'professor@test.me'])) {
            $admin = (new Professor())
                ->setEmail('professor@test.me')
                ->setPlainPassword('professor')
                ->setName('professor');
            $em->persist($admin);
            $em->flush();
            $em->refresh($admin);
        }

        return new JsonResponse(['token' => $manager->create($admin)]);
    }

    /** @Route(name="student", path="/student")  */
    public function getStudent(JWTTokenManagerInterface $manager): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Student::class);

        /**
         * @var User $admin
         */
        if (null === $admin = $repository->findOneBy(['email' => 'student@test.me'])) {
            $admin = (new Student())
                ->setEmail('student@test.me')
                ->setPlainPassword('student')
                ->setName('student');
            $em->persist($admin);
            $em->flush();
            $em->refresh($admin);
        }

        return new JsonResponse(['token' => $manager->create($admin)]);
    }
}
