<?php

namespace App\Controller\Api;

use App\Repository\MenuRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/menu", name="app_api_menu")
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
    $menu = $this->menuRepository->findActive();
    if (empty($menu)) {
      return $this->json(["message" => "Nessun menu attivo trovato."], Response::HTTP_NOT_FOUND);
    }
    return $this->json($menu, Response::HTTP_OK, [], ['groups' => 'public']);
  }

  /**
   * @Route("/example", name="app_api_menu_example", methods={"GET"})
   */
  public function example(): JsonResponse
  {
    return $this->json(array(
      'sections' =>
      array(
        0 =>
        array(
          'title' => 'Antipasti',
          'sorting' => 0,
          'entries' =>
          array(
            0 =>
            array(
              'name' => 'apetizer0',
              'description' => NULL,
              'price' => '10.50',
              'quantity' => 6,
            ),
            1 =>
            array(
              'name' => 'apetizer1',
              'description' => NULL,
              'price' => '10.50',
              'quantity' => 6,
            ),
            2 =>
            array(
              'name' => 'apetizer2',
              'description' => NULL,
              'price' => '10.50',
              'quantity' => 20,
            ),
          ),
        ),
        1 =>
        array(
          'title' => 'Primi Piatti',
          'sorting' => 1,
          'entries' =>
          array(
            0 =>
            array(
              'name' => 'mainCourse0',
              'description' => NULL,
              'price' => '10.50',
              'quantity' => 10,
            ),
            1 =>
            array(
              'name' => 'mainCourse1',
              'description' => NULL,
              'price' => '10.50',
              'quantity' => 15,
            ),
            2 =>
            array(
              'name' => 'mainCourse2',
              'description' => NULL,
              'price' => '10.50',
              'quantity' => 17,
            ),
          ),
        ),
        2 =>
        array(
          'title' => 'Secondi Piatti',
          'sorting' => 2,
          'entries' =>
          array(
            0 =>
            array(
              'name' => 'secondDish0',
              'description' => NULL,
              'price' => '10.50',
              'quantity' => 20,
            ),
            1 =>
            array(
              'name' => 'secondDish1',
              'description' => NULL,
              'price' => '10.50',
              'quantity' => 11,
            ),
            2 =>
            array(
              'name' => 'secondDish2',
              'description' => NULL,
              'price' => '10.50',
              'quantity' => 12,
            ),
          ),
        ),
      ),
    ));
  }
}
