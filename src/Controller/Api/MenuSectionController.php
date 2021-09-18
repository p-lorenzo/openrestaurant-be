<?php

namespace App\Controller\Api;

use App\Entity\MenuSection;
use App\Form\MenuSectionType;
use App\Repository\MenuSectionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
        return $this->json($this->menuSectionRepository->findBy([], ['sorting' => 'ASC']), Response::HTTP_OK, [], ['groups' => 'public']);
    }

    /**
     * @Route("/update/{id}", name="app_api_menusection_update", methods={"POST"})
     */
    public function update(MenuSection $menuSection, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (empty($data)) {
            return $this->json(["message" => "Empty data"], Response::HTTP_BAD_REQUEST);
        }

        $form = $this->createForm(MenuSectionType::class, $menuSection)->submit($data);
        if (!$form->isValid()) {
            $errors = [];
            foreach ($form->getErrors(true) as $error) {
                $errors[] = $error->getOrigin()->getName() . ": " . $error->getMessage();
            }

            return $this->json(implode(" - ", $errors), 422);
        }

        try {
            $this->entityManager->persist($menuSection);
            $this->entityManager->flush();

            return new JsonResponse(['status' => 'Sezione aggiornata!'], Response::HTTP_CREATED);
        } catch (\Exception $ex) {
            return $this->json(["message" => "Inserimento fallito " . $ex->getMessage()], 500);
        }
    }

    /**
     * @Route("/add", name="app_api_menusection_item", methods={"POST"})
     */
    public function item(Request $request): JsonResponse
    {
        $menuSection = new MenuSection();
        $data = json_decode($request->getContent(), true);
        if (empty($data)) {
            return $this->json(["message" => "Empty data"], Response::HTTP_BAD_REQUEST);
        }

        $form = $this->createForm(MenuSectionType::class, $menuSection)->submit($data);
        if (!$form->isValid()) {
            $errors = [];
            foreach ($form->getErrors(true) as $error) {
                $errors[] = $error->getOrigin()->getName() . ": " . $error->getMessage();
            }

            return $this->json(implode(" - ", $errors), 422);
        }

        try {
            $this->entityManager->persist($menuSection);
            $this->entityManager->flush();

            return new JsonResponse(['status' => 'Sezione aggiornata!'], Response::HTTP_CREATED);
        } catch (\Exception $ex) {
            return $this->json(["message" => "Inserimento fallito " . $ex->getMessage()], 500);
        }
    }

    /**
     * @Route("/delete/{id}", name="app_api_menusection_delete", methods={"DELETE"})
     */
    public function delete(MenuSection $menuSection)
    {
        $this->entityManager->remove($menuSection);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Sezione menu rimossa!'], Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/{id}", name="app_api_menusection_detail", methods={"GET"})
     */
    public function detail(MenuSection $menuSection)
    {
        return $this->json($menuSection, Response::HTTP_OK, [], ['groups' => 'public']);
    }
}
