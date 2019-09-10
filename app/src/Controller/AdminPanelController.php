<?php
/**
 * Admin panel controller.
 */
namespace App\Controller;

use App\Entity\Ticket;
use App\Entity\User;
use App\Form\TicketType;
use App\Repository\TicketRepository;
use App\Repository\UserRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
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
    public function viewTickets(PaginatorInterface $paginator, Request $request, TicketRepository $repository): Response
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

    /**
     * @param Request $request
     * @param Ticket $ticket
     * @param TicketRepository $repository
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route("/tickets/{id}/delete",
     *     methods={"GET", "DELETE"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="ticket_delete"
     * )
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

            return $this->redirectToRoute('admin_panelticket_index');
        }

        return $this->render(
            'admin_panel/delete_ticket.html.twig',
            [
                'form' => $form->createView(),
                'ticket' => $ticket,
            ]
        );
    }
}
