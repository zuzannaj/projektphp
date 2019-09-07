<?php
/**
 * Admin panel controller.
 */
namespace App\Controller;

use App\Entity\User;
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
}
