<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class DefaultController extends AbstractController
{

    /**
     * @Route("/", name="app_default")
     */
    public function default()
    {
        return $this->render("base.html.twig");
    }
}
