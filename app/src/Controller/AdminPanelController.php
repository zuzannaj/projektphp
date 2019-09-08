<?php
/**
 * Admin panel controller.
 */
namespace App\Controller;

use App\Entity\Ticket;
use App\Entity\User;
use App\Repository\TicketRepository;
use App\Repository\UserRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/adminpanel", name="admin_panel")
 */
class AdminPanelController extends Controller
{
    /**
     * Index Admin Panel.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/", name="admin_panel_index")
     */
    public function index()
    {
        return $this->render('admin_panel/index.html.twig', [
            'controller_name' => 'AdminPanelController',
        ]);
    }

    /**
     * @param PaginationInterface $paginator
     * @param Request $request
     * @param UserRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/users", name="user_index")
     */
    public function users(PaginatorInterface $paginator, Request $request, UserRepository $repository): Response
    {
        $pagination = $paginator->paginate(
            $repository->queryAll(),
            $request->query->getInt('page', 1),
            User::NUMBER_OF_ITEMS
        );
        return $this->render('admin_panel/users.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @param TicketRepository $repository
     * @return Response
     *
     * @Route("/tickets", name="ticket_index")
     */
    public function tickets(PaginatorInterface $paginator, Request $request, TicketRepository $repository): Response
    {
        $pagination = $paginator->paginate(
            $repository->queryAll(),
            $request->query->getInt('page', 1),
            Ticket::NUMBER_OF_ITEMS
        );
        return $this->render('admin_panel/tickets.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @param TicketRepository $repository
     * @param int $id
     * @return Response
     *
     * @Route("/tickets/{id}", name="ticket_view")
     */
    public function viewOneTicket(TicketRepository $repository, int $id): Response
    {
        return $this->render(
            'admin_panel/view_one_ticket.html.twig',
            ['item' => $repository->find($id)]
        );
    }
}
