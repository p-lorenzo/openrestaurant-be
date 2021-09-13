<?php

namespace App\Controller\Api;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/admin", name="app_api_admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/test", name="app_api_admin_test", methods={"GET"})
     */
    public function default(): JsonResponse
    {
        return $this->json([
            "message" => "Autenticazione riuscita"
        ]);
    }
}
