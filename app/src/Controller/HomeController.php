<?php
/**
 * Home controller.
 */
namespace App\Controller;

use App\Entity\BusLine;
use App\Entity\Stop;
use App\Repository\BusLineRepository;
use App\Repository\StopRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController.
 */
class HomeController extends Controller
{
    /**
     * Index.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/", name="homepage")
     */
    public function index()
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * View one stop.
     *
     * @param StopRepository $repository
     * @param int            $id
     *
     * @return Response
     *
     * @Route("/stops/{id}", name="stops_view_one", requirements={"id": "[1-9]\d*"})
     */
    public function viewStop(StopRepository $repository, int $id): Response
    {
        return $this->render(
            'stop/view.html.twig',
            ['item' => $repository->find($id)]
        );
    }

    /**
     * View stops.
     *
     * @param StopRepository     $repository
     * @param PaginatorInterface $paginator
     * @param Request            $request
     *
     * @return Response
     *
     * @Route(
     *     "/stops",
     *     name="stops_view"
     * )
     */
    public function viewStops(StopRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $pagination = $paginator->paginate(
            $repository->queryAll(),
            $request->query->getInt('page', 1),
            Stop::NUMBER_OF_ITEMS
        );

        return $this->render(
            'home/stops.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * View bus lines.
     *
     * @param Request            $request
     * @param BusLineRepository  $repository
     * @param PaginatorInterface $paginator
     *
     * @return Response
     *
     * @Route(
     *     "/lines",
     *     name="view_lines"
     * )
     */
    public function viewLines(Request $request, BusLineRepository $repository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $repository->queryAll(),
            $request->query->getInt('page', 1),
            BusLine::NUMBER_OF_ITEMS
        );

        return $this->render(
            'home/lines.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * View one bus line.
     * @param BusLineRepository $repository
     * @param int               $id
     *
     * @return Response
     *
     * @Route("/lines/{id}", name="view_line", requirements={"id": "[1-9]\d*"})
     */
    public function viewLine(BusLineRepository $repository, int $id): Response
    {
        return $this->render(
            'home/view_line.html.twig',
            ['item' => $repository->find($id),
                ]
        );
    }
}
