<?php

namespace App\Controller\Api;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;
use Symfony\Component\Uid\Uuid;

class AuthenticationController extends AbstractController
{
    private PasswordHasherFactoryInterface $passwordHasher;
    private UserRepository $userRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(PasswordHasherFactoryInterface $passwordHasher, UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        $this->passwordHasher = $passwordHasher;
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/login", name="app_api_authentication_login",  methods={"POST"})
     */
    public function login(Request $request): JsonResponse
    {
        $body = json_decode($request->getContent(), true);

        if (empty($body)) {
            return $this->createAccessDeniedException("Missing credentials.");
        }

        if (empty($body['email'])) {
            return $this->createAccessDeniedException("Missing email.");
        }

        $user = $this->userRepository->findOneBy(['email' => $body['email']]);
        if (empty($user)) {
            return $this->createAccessDeniedException("User not found");
        }
        $hasher = $this->passwordHasher->getPasswordHasher($user);
        if (!$hasher->verify($user->getPassword(), $body['password'])) {
            return $this->createAccessDeniedException("Wrong password.");
        }
        $token = Uuid::v1();
        $user->setApiToken($token);
        $this->entityManager->flush();
        return $this->json(["token" => $token, "user" => $user]);
    }
}
