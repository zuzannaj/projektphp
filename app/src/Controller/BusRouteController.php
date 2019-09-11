<?php
/**
 * Bus route controller.
 */
namespace App\Controller;

use App\Entity\BusRoute;
use App\Form\BusRouteType;
use App\Repository\BusRouteRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
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
     * Index.
     *
     * @param BusRouteRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request            $request
     *
     * @return Response
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
     * View.
     *
     * @param BusRouteRepository $repository
     * @param int                $id
     *
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
     * New.
     *
     * @param Request            $request
     * @param BusRouteRepository $repository
     *
     * @return Response
     *
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

    /**
     * Delete.
     *
     * @param Request            $request
     * @param BusRoute           $busRoute
     * @param BusRouteRepository $repository
     *
     * @return Response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/delete",
     *     methods={"GET", "DELETE"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="route_delete",
     * )
     */
    public function delete(Request $request, BusRoute $busRoute, BusRouteRepository $repository): Response
    {
        $form = $this->createForm(FormType::class, $busRoute, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->delete($busRoute);
            $this->addFlash('success', 'message.deleted_successfully');

            return $this->redirectToRoute('route_index');
        }

        return $this->render(
            'bus_route/delete.html.twig',
            [
                'form' => $form->createView(),
                'busRoute' => $busRoute,
            ]
        );
    }

    /**
     * Edit.
     *
     * @param Request            $request
     * @param BusRoute           $busRoute
     * @param BusRouteRepository $repository
     *
     * @return Response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/edit",
     *     methods={"GET", "PUT"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="route_edit",
     * )
     */
    public function edit(Request $request, BusRoute $busRoute, BusRouteRepository $repository): Response
    {
        $form = $this->createForm(BusRouteType::class, $busRoute, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->save($busRoute);

            $this->addFlash('success', 'message.updated_successfully');

            return $this->redirectToRoute('route_index');
        }

        return $this->render(
            'bus_route/edit.html.twig',
            [
                'form' => $form->createView(),
                'busRoute' => $busRoute,
            ]
        );
    }
}
