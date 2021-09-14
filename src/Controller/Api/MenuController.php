<?php

namespace App\Controller\Api;

use App\Repository\MenuRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/menu", name="app_api_public")
 */
class MenuController extends AbstractController
{
    private MenuRepository $menuRepository;

    public function __construct(MenuRepository $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    /**
     * @Route("/active", name="app_api_menu_active", methods={"GET"})
     */
    public function active(): JsonResponse
    {
        return $this->json($this->menuRepository->findActive());
    }
}
