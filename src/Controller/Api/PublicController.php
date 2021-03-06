<?php

namespace App\Controller\Api;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/public", name="app_api_public")
 */
class PublicController extends AbstractController
{
    /**
     * @Route("/", name="app_api_public_default", methods={"GET"})
     */
    public function default(): JsonResponse
    {
        return $this->json([
            "message" => "Hello world!"
        ]);
    }
}
