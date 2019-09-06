<?php
/**
 * Bus Route controller.
 */

namespace App\Controller;

use App\Entity\BusRoute;
use App\Form\BusRouteType;
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

    /**
     * @param BusRouteRepository $repository
     * @param int $id
     * @return Response
     *
     * @Route("/{id}", name="route_view", requirements={"id": "[1-9]\d*"})
     */
    public function view(BusRouteRepository $repository, int $id): Response
    {
        return $this->render(
            'bus_route/view.html.twig',
            ['item' => $repository->find($id)]
        );
    }

    /**
     * @param Request $request
     * @param BusRouteRepository $repository
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/new",
     *     methods={"GET", "POST"},
     *     name="route_new",
     * )
     */
    public function new(Request $request, BusRouteRepository $repository): Response
    {
        $busRoute = new BusRoute();
        $form = $this->createForm(BusRouteType::class, $busRoute);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->save($busRoute);

            return $this->redirectToRoute('route_index');
        }

        return $this->render(
            'bus_route/new.html.twig',
            ['form' => $form->createView()]
        );
    }

}

