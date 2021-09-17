<?php

namespace App\Controller\Api;

use App\Entity\MenuSection;
use App\Repository\MenuSectionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/menu-section", name="app_api_menu")
 */
class MenuSectionController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private MenuSectionRepository $menuSectionRepository;

    public function __construct(EntityManagerInterface $entityManager, MenuSectionRepository $menuSectionRepository)
    {
        $this->entityManager = $entityManager;
        $this->menuSectionRepository = $menuSectionRepository;
    }

    /**
     * @Route("/", name="app_api_menusection_index", methods={"GET"})
     */
    public function index(): JsonResponse
    {
        return $this->json($this->menuSectionRepository->findAll(), Response::HTTP_OK, [], ['groups' => 'public']);
    }

    /**
     * @Route("/add", name="app_api_menusection_add", methods={"POST"})
     */
    // public function item(Request $request): JsonResponse
    // {
    //     $menuSection = new MenuSection();
    //     $data = json_decode($request->getContent(), true);

    //     $name = $data['name'];
    //     $description = $data['description'];
    //     $price = $data['price'];
    //     $quantity = $data['quantity'];

    //     if (empty($name) || empty($price) || empty($quantity)) {
    //         throw new NotFoundHttpException('Expecting mandatory parameters!');
    //     }

    //     $menuSection->setName($name)
    //         ->setPrice($price)
    //         ->setQuantity($quantity)
    //         ->setDescription($description);
    //     $this->entityManager->persist($menuSection);
    //     $this->entityManager->flush();

    //     return new JsonResponse(['status' => 'Sezione menu aggiunta!'], Response::HTTP_CREATED);
    // }

    /**
     * @Route("/update/{id}", name="app_api_menusection_update", methods={"POST"})
     */
    // public function update(MenuSection $menuSection, Request $request): JsonResponse
    // {
    //     $data = json_decode($request->getContent(), true);

    //     $name = $data['name'];
    //     $description = $data['description'];
    //     $price = $data['price'];
    //     $quantity = $data['quantity'];

    //     if (empty($name) || empty($price) || empty($quantity)) {
    //         throw new NotFoundHttpException('Expecting mandatory parameters!');
    //     }

    //     $menuSection->setName($name)
    //         ->setPrice($price)
    //         ->setQuantity($quantity)
    //         ->setDescription($description);
    //     $this->entityManager->persist($menuSection);
    //     $this->entityManager->flush();

    //     return new JsonResponse(['status' => 'Sezione menu aggiornata!'], Response::HTTP_CREATED);
    // }

    /**
     * @Route("/delete/{id}", name="app_api_menusection_delete", methods={"DELETE"})
     */
    public function delete(MenuSection $menuSection)
    {
        $this->entityManager->remove($menuSection);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Sezione menu rimossa!'], Response::HTTP_NO_CONTENT);
    }
}
