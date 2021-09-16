<?php

namespace App\Controller\Api;

use App\Entity\MenuEntry;
use App\Repository\MenuEntryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @Route("/admin/menu-entry", name="app_api_menu")
 */
class MenuEntryController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private MenuEntryRepository $menuEntryRepository;

    public function __construct(EntityManagerInterface $entityManager, MenuEntryRepository $menuEntryRepository)
    {
        $this->entityManager = $entityManager;
        $this->menuEntryRepository = $menuEntryRepository;
    }

    /**
     * @Route("/", name="app_api_menuentry_index", methods={"GET"})
     */
    public function index(): JsonResponse
    {
        return $this->json($this->menuEntryRepository->findAll(), Response::HTTP_OK, [], ['groups' => 'public']);
    }

    /**
     * @Route("/add", name="app_api_menuentry_add", methods={"POST"})
     */
    public function item(Request $request): JsonResponse
    {
        $menuEntry = new MenuEntry();
        $data = json_decode($request->getContent(), true);

        $name = $data['name'];
        $description = $data['description'];
        $price = $data['price'];
        $quantity = $data['quantity'];

        if (empty($name) || empty($price) || empty($quantity)) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        $menuEntry->setName($name)
            ->setPrice($price)
            ->setQuantity($quantity)
            ->setDescription($description);
        $this->entityManager->persist($menuEntry);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Pietanza aggiunta!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/update/{id}", name="app_api_menuentry_update", methods={"POST"})
     */
    public function update(MenuEntry $menuEntry, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $name = $data['name'];
        $description = $data['description'];
        $price = $data['price'];
        $quantity = $data['quantity'];

        if (empty($name) || empty($price) || empty($quantity)) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        $menuEntry->setName($name)
            ->setPrice($price)
            ->setQuantity($quantity)
            ->setDescription($description);
        $this->entityManager->persist($menuEntry);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Pietanza aggiornata!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/delete/{id}", name="app_api_menuentry_delete", methods={"DELETE"})
     */
    public function delete(MenuEntry $menuEntry)
    {
        $this->entityManager->remove($menuEntry);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Pietanza rimossa!'], Response::HTTP_NO_CONTENT);
    }
}
