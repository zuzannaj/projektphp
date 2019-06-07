<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class FirstClass
 */

class FirstController extends AbstractController
{
    /**
     * @param $name
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/first")
     */

    public function firstFunction($name): Response
    {
        return $this->render(
            'first/index.html.twig',
            ['name' => $name]
        );
    }

}
