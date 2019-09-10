<?php
/**
 * Search controller.
 */
namespace App\Controller;

use App\Entity\BusLine;
use App\Entity\BusRoute;
use App\Entity\Stop;
use App\Entity\Ticket;
use App\Form\BuyTicketType;
use App\Form\TicketType;
use App\Repository\BusLineRepository;
use App\Repository\BusRouteRepository;
use App\Repository\TicketRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use function Sodium\add;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SearchController
 * @package App\Controller
 *
 * @Route("/search", name="search")
 */
class SearchController extends Controller
{
    /**
     * Search action.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/", name="search_index")
     */
    public function search()
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('searchsearchresults'))
            ->add('query', TextType::class, [
        'attr' => [
            'class' => 'searchlink',
        ],])
            ->add('search', SubmitType::class, [
                'attr' => [
                    'class' => 'buttonstyle',
                ],
            ])
            ->getForm();

        return $this->render('search/searchbar.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param BusRouteRepository $repository
     * @param PaginatorInterface $paginator
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/searchresults", name="searchresults")
     */
    public function handleSearch(Request $request, BusRouteRepository $repository, PaginatorInterface $paginator)
    {
        $query = $request->request->get('form')['query'];

        $pagination = $paginator->paginate(
                $repository->search($query),
                $request->query->getInt('page', 1),
                BusRoute::NUMBER_OF_ITEMS
            );

        return $this->render('search/searchresults.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @param Request $request
     * @param TicketRepository $repository
     * @param string $name
     * @param Stop $stop
     * @param int $number
     * @param BusLine $busLine
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @ParamConverter("stop", class="App\Entity\Stop")
     * @ParamConverter("busLine", class="App\Entity\BusLine")
     *
     * @Route("/searchresults/{name}/{number}/buy", methods={"GET", "POST", "PUT"}, name="ticket_buy")
     */
    public function buyTicket(Request $request, TicketRepository $repository, string $name, Stop $stop, int $number, BusLine $busLine): Response
    {
        $ticket = new Ticket();
        $form = $this->createForm(BuyTicketType::class, $ticket);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $ticket->setCreatedAt(new \DateTime());
            $ticket->setBusLine($busLine);
            $ticket->setUser($this->getUser());
            $ticket->setFirstStop($stop);
            //$ticket->setLastStop($stop);
            $repository->save($ticket);

            return $this->redirectToRoute('searchticket_view');
        }

        return $this->render(
            'ticket/buy.html.twig',
            ['form' => $form->createView(),
                'number' => $number,
                'firstStop' => $name,
            ]
        );
    }
    /*/**
     * @param PaginatorInterface $paginator
     * @param BusRouteRepository $repository
     * @param Request $request
     * @param int $number
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/searchresults/line/{number}", name="searchresults_line")
     *//*
    public function showStops(PaginatorInterface $paginator, BusRouteRepository $repository, Request $request, int $number)
    {
        $pagination = $paginator->paginate(
            $repository->showLine($number),
            $request->query->getInt('page', 1),
            BusRoute::NUMBER_OF_ITEMS
        );

        return $this->render('search/line.html.twig', [
            'pagination' => $pagination,
            'line' => $number,
        ]);
    }

    /**
     * @param Request $request
     * @param TicketRepository $repository
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/buy",
     *     methods={"GET", "POST"},
     *     name="ticket_buy",
     * )
     */
    /*
    public function new(Request $request, TicketRepository $repository): Response
    {
        $ticket = new Ticket();
        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ticket->setCreatedAt(new \DateTime());
            $ticket->setUser($this->getUser());
            $repository->save($ticket);

            return $this->redirectToRoute('searchticket_view');
        }

        return $this->render(
            'ticket/buy.html.twig',
            ['form' => $form->createView(),
            ]
        );
    }
*/
    /**
     * @param PaginatorInterface $paginator
     * @param TicketRepository $repository
     * @param Request $request
     * @return Response
     *
     * @Route(
     *     "/view",
     *     methods={"GET", "POST"},
     *     name="ticket_view",
     * )
     */
    public function viewTickets(PaginatorInterface $paginator, TicketRepository $repository, Request $request)
    {
        $pagination = $paginator->paginate(
            $repository->queryAll(),
            $request->query->getInt('page', 1),
            Ticket::NUMBER_OF_ITEMS
        );
        return $this->render('ticket/view.html.twig', ['pagination' => $pagination]);
    }

    /**
     * @param TicketRepository $repository
     * @param int $id
     * @return Response
     *
     * @Route("/ticketview/{id}", name="ticket_view_one", requirements={"id": "[1-9]\d*"})
     */
    public function viewOne(TicketRepository $repository, int $id): Response
    {
        return $this->render(
            'ticket/view_one.html.twig',
            ['item' => $repository->find($id)]
        );
    }
    /*
        /**
         * @param Request $request
         * @param TicketRepository $repository
         * @param BusLine $busLine
         * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
         * @throws \Doctrine\ORM\ORMException
         * @throws \Doctrine\ORM\OptimisticLockException
         *
         * @Route(
         *     "/buy",
         *     methods={"GET", "POST"},
         *     name="ticket_buy",
         * )
         */
/*
    public function buyTicket(Request $request, TicketRepository $repository, BusLine $busLine)
    {
        $ticket = new Ticket();
        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);
        $line = $form['bus_line']->getData();
        if ($line) {
            if ($form->isSubmitted() && $form->isValid()) {
                $ticket->setUser($this->getUser());
                $ticket->setCreatedAt(new \DateTime());
                $ticket->setBusLine($busLine);
                $repository->save($ticket);
                $this->addFlash('success', 'message.created_successfully');

                return $this->redirectToRoute('homepage');
            }
        }

        return $this->render(
            'ticket/buy.html.twig',
            ['form' => $form->createView(),
                'busLine' => $busLine,
            ]
        );
    }*/
}
