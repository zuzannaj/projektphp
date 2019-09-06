<?php
/**
 * Bus Line controller.
 */

namespace App\Controller;

use App\Entity\BusLine;
use App\Form\BusLineType;
use App\Repository\BusLineRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BusLineController.
 *
 * @Route("/adminpanel/buslines")
 */
class BusLineController extends AbstractController
{
    /**
     * Index action.
     *
     * @param \App\Repository\BusLineRepository $repository Repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/",
     *     name="busline_index"
     * )
     */
    public function index(Request $request, BusLineRepository $repository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $repository->queryAll(),
            $request->query->getInt('page', 1),
            BusLine::NUMBER_OF_ITEMS
        );

        return $this->render(
            'bus_line/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * @param BusLineRepository $repository
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response Http response
     *
     * @Route("/{id}", name="busline_view", requirements={"id": "[1-9]\d*"})
     */
    public function view(BusLineRepository $repository, int $id): Response
    {
        return $this->render(
            'bus_line/view.html.twig',
            ['item' => $repository->find($id)]
        );
    }

    /**
     * New action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request    HTTP request
     * @param \App\Repository\StopRepository        $repository Stop repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/new",
     *     methods={"GET", "POST"},
     *     name="busline_new",
     * )
     */
    public function new(Request $request, BusLineRepository $repository): Response
    {
        $busline = new BusLine();
        $form = $this->createForm(BusLineType::class, $busline);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->save($busline);

            return $this->redirectToRoute('busline_index');
        }

        return $this->render(
            'bus_line/new.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request    HTTP request
     * @param BusLine
     * @param \App\Repository\BusLineRepository    $repository BusLine repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/delete",
     *     methods={"GET", "DELETE"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="busline_delete",
     * )
     */
    public function delete(Request $request, BusLine $busline, BusLineRepository $repository): Response
    {
        $form = $this->createForm(FormType::class, $busline, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->delete($busline);
            $this->addFlash('success', 'message.deleted_successfully');

            return $this->redirectToRoute('busline_index');
        }

        return $this->render(
            'bus_line/delete.html.twig',
            [
                'form' => $form->createView(),
                'busline' => $busline,
            ]
        );
    }
}
