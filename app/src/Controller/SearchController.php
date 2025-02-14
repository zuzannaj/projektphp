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
use App\Repository\BusRouteRepository;
use App\Repository\TicketRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SearchController
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
     * @param string $query
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
                ],
            ])
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
     * Handle search.
     *
     * @param Request            $request
     * @param BusRouteRepository $repository
     * @param PaginatorInterface $paginator
     *
     * @return Response
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
            'query' => $query,
        ]);
    }

    /**
     * Buy ticket.
     *
     * @param Request          $request
     * @param TicketRepository $repository
     * @param string           $name
     * @param Stop             $stop
     * @param int              $number
     * @param BusLine          $busLine
     *
     * @return Response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route("/searchresults/{name}/{number}/buy", methods={"GET", "POST", "PUT"}, name="ticket_buy")
     */
    public function buyTicket(Request $request, TicketRepository $repository, string $name, Stop $stop, int $number, BusLine $busLine): Response
    {
        $ticket = new Ticket();
        $form = $this->createForm(BuyTicketType::class, $ticket, array('stop' => $busLine->getNumber()));
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

    /**
     * View tickets.
     *
     * @param PaginatorInterface $paginator
     * @param TicketRepository   $repository
     * @param Request            $request
     *
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
     * View one.
     *
     * @param TicketRepository $repository
     * @param int              $id
     *
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

    /**
     * Delete ticket.
     *
     * @param Request          $request
     * @param Ticket           $ticket
     * @param TicketRepository $repository
     *
     * @return Response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route("/ticketdelete/{id}", name="ticket_delete_one", requirements={"id": "[1-9]\d*"})
     */
    public function deleteTicket(Request $request, Ticket $ticket, TicketRepository $repository): Response
    {
        //$stop = $repository->find($id);
        $form = $this->createForm(FormType::class, $ticket, ['method' => 'DELETE']);
        $form->handleRequest($request);


        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->delete($ticket);
            $this->addFlash('success', 'message.deleted_successfully');

            return $this->redirectToRoute('searchticket_view');
        }

        return $this->render(
            'ticket/delete.html.twig',
            [
                'form' => $form->createView(),
                'ticket' => $ticket,
            ]
        );
    }
}
