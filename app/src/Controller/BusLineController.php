<?php
/**
 * Bus Line controller.
 */

namespace App\Controller;

use App\Entity\BusLine;
use App\Repository\BusLineRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BusLineController.
 *
 * @Route("/adminpanel/buslines")
 */
class BusLineController extends AbstractController
{
    /**
     * Index action.
     *
     * @param \App\Repository\BusLineRepository $repository Repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/",
     *     name="buslines"
     * )
     */
    public function index(BusLineRepository $repository): Response
    {
        return $this->render(
            'bus_line/index.html.twig',
            ['data' => $repository->findAll()]
        );
    }
}
