<?php

namespace App\Controller\Api;

use App\Entity\MenuEntry;
use App\Form\MenuEntryType;
use App\Repository\MenuEntryRepository;
use App\Repository\MenuSectionRepository;
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
    private MenuSectionRepository $menuSectionRepository;

    public function __construct(EntityManagerInterface $entityManager, MenuEntryRepository $menuEntryRepository, MenuSectionRepository $menuSectionRepository)
    {
        $this->entityManager = $entityManager;
        $this->menuEntryRepository = $menuEntryRepository;
        $this->menuSectionRepository = $menuSectionRepository;
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
        if (empty($data)) {
            return $this->json(["message" => "Empty data"], Response::HTTP_BAD_REQUEST);
        }

        $form = $this->createForm(MenuEntryType::class, $menuEntry)->submit($data);
        if (!$form->isValid()) {
            $errors = [];
            foreach ($form->getErrors(true) as $error) {
                $errors[] = $error->getOrigin()->getName() . ": " . $error->getMessage();
            }

            return $this->json(implode(" - ", $errors), 422);
        }

        try {
            $menuEntry->setMenuSection($this->menuSectionRepository->findOneBy(['id' => $form['menuSectionId']->getData()]));
            $this->entityManager->persist($menuEntry);
            $this->entityManager->flush();

            return new JsonResponse(['status' => 'Pietanza aggiunta!'], Response::HTTP_CREATED);
        } catch (\Exception $ex) {
            return $this->json(["message" => "Inserimento fallito " . $ex->getMessage()], 500);
        }
    }

    /**
     * @Route("/update/{id}", name="app_api_menuentry_update", methods={"POST"})
     */
    public function update(MenuEntry $menuEntry, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (empty($data)) {
            return $this->json(["message" => "Empty data"], Response::HTTP_BAD_REQUEST);
        }

        $form = $this->createForm(MenuEntryType::class, $menuEntry)->submit($data);
        if (!$form->isValid()) {
            $errors = [];
            foreach ($form->getErrors(true) as $error) {
                $errors[] = $error->getOrigin()->getName() . ": " . $error->getMessage();
            }

            return $this->json(implode(" - ", $errors), 422);
        }

        try {
            $menuEntry->setMenuSection($this->menuSectionRepository->findOneBy(['id' => $form['menuSectionId']->getData()]));
            $this->entityManager->persist($menuEntry);
            $this->entityManager->flush();

            return new JsonResponse(['status' => 'Pietanza aggiornata!'], Response::HTTP_CREATED);
        } catch (\Exception $ex) {
            return $this->json(["message" => "Inserimento fallito " . $ex->getMessage()], 500);
        }
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

    /**
     * @Route("/{id}", name="app_api_menuentry_detail", methods={"GET"})
     */
    public function detail(MenuEntry $menuEntry)
    {
        return $this->json($menuEntry, Response::HTTP_OK, [], ['groups' => 'details']);
    }
}
