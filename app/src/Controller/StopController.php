<?php
/**
 * Stop controller.
 */

namespace App\Controller;

use App\Entity\Stop;
use App\Repository\StopRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class StopController.
 *
 * @Route("/adminpanel/stops")
 */
class StopController extends AbstractController
{
    /**
     * Index action.
     *
     * @param \App\Repository\StopRepository $repository Repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/",
     *     name="stop_index"
     * )
     */
    public function index(StopRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $pagination = $paginator->paginate(
            $repository->queryAll(),
            $request->query->getInt('page', 1),
            Stop::NUMBER_OF_ITEMS
        );

        return $this->render(
            'stop/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * @param StopRepository $repository
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response Http response
     *
     * @Route("/{id}", name="stop_view", requirements={"id": "[1-9]\d*"})
     */
    public function view(StopRepository $repository, int $id): Response
    {
        return $this->render(
            'stop/view.html.twig',
            ['item' => $repository->find($id)]
        );
    }
}