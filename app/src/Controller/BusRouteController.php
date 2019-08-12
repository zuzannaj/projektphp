<?php
/**
 * Bus Route controller.
 */

namespace App\Controller;

use App\Entity\BusRoute;
use App\Repository\BusRouteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BusRouteController.
 *
 * @Route("/adminpanel/routes")
 */
class BusRouteController extends AbstractController
{
    /**
     * Index action.
     *
     * @param \App\Repository\BusRouteRepository $repository Repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/",
     *     name="routes"
     * )
     */
    public function index(BusRouteRepository $repository): Response
    {
        return $this->render(
            'bus_route/index.html.twig',
            ['data' => $repository->findAll()]
        );
    }
}

