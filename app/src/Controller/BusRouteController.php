<?php
/**
 * Bus Route controller.
 */

namespace App\Controller;

use App\Entity\BusRoute;
use App\Repository\BusRouteRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     *     name="route_index"
     * )
     */
    public function index(BusRouteRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $pagination = $paginator->paginate(
            $repository->queryAll(),
            $request->query->getInt('page', 1),
            BusRoute::NUMBER_OF_ITEMS
        );

        return $this->render(
            'bus_route/index.html.twig',
            ['pagination' => $pagination]
        );
    }

}

