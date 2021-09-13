<?php

namespace App\Controller\Api;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;


class PublicController extends AbstractController
{
    /**
     * @Route("/api", name="app_api_default", methods={"GET"})
     */
    public function default()
    {
        return $this->json([
            "message" => "Hello world!"
        ]);
    }
}
