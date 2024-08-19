<?php
// src/Controller/SignupController.php
namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SignupController extends AbstractController
{
    private $entityManager;
    private $passwordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @Route("/signup", name="signup", methods={"POST"})
     */
    public function signup(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        // Validate data (you should implement your validation logic here)

        // Create a new user entity
        $user = new User();
        $user->setEmail($data['email']);
        $user->setRoles([$data['roles'] ?? 'ROLE_USER']); // Ensure roles are an array

        // Hash the password before saving
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $data['password']
        );
        $user->setPassword($hashedPassword);

        // Save the user to the database
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->json([
            'message' => 'Signup successful',
            'data' => $data,
        ]);
    }
}
