<?php
// src/Controller/UserController.php
namespace App\Controller;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/users", name="list_users", methods={"GET"})
     */
/*    public function listUsers(SerializerInterface $serializer): JsonResponse
    {
        $users = $this->entityManager->getRepository(User::class)->findAll();

        $jsonUser = $serializer->serialize($users,"json",["groups"=> "users"]);

        return new JsonResponse($jsonUser, JsonResponse::HTTP_OK);
    }*/
}