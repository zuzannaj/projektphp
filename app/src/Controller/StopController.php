<?php
/**
 * Stop controller.
 */
namespace App\Controller;

use App\Entity\Stop;
use App\Form\StopType;
use App\Repository\StopRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
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
     * Index.
     *
     * @param StopRepository     $repository
     * @param PaginatorInterface $paginator
     * @param Request            $request
     *
     * @return Response
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
     * View.
     *
     * @param StopRepository $repository
     * @param int            $id
     *
     * @return Response
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

    /**
     * New.
     *
     * @param Request        $request
     * @param StopRepository $repository
     *
     * @return Response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/new",
     *     methods={"GET", "POST"},
     *     name="stop_new",
     * )
     */
    public function new(Request $request, StopRepository $repository): Response
    {
        $stop = new Stop();
        $form = $this->createForm(StopType::class, $stop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->save($stop);

            return $this->redirectToRoute('stop_index');
        }

        return $this->render(
            'stop/new.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Delete.
     *
     * @param Request        $request
     * @param Stop           $stop
     * @param StopRepository $repository
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
     *     name="stop_delete",
     * )
     */
    public function delete(Request $request, Stop $stop, StopRepository $repository): Response
    {
        //$stop = $repository->find($id);
        $form = $this->createForm(FormType::class, $stop, ['method' => 'DELETE']);
        $form->handleRequest($request);


        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->delete($stop);
            $this->addFlash('success', 'message.deleted_successfully');

            return $this->redirectToRoute('stop_index');
        }

        return $this->render(
            'stop/delete.html.twig',
            [
                'form' => $form->createView(),
                'stop' => $stop,
            ]
        );
    }

    /**
     * Edit.
     *
     * @param Request        $request
     * @param Stop           $stop
     * @param StopRepository $repository
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
     *     name="stop_edit",
     * )
     */
    public function edit(Request $request, Stop $stop, StopRepository $repository): Response
    {
        $form = $this->createForm(StopType::class, $stop, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->save($stop);

            $this->addFlash('success', 'message.updated_successfully');

            return $this->redirectToRoute('stop_index');
        }

        return $this->render(
            'stop/edit.html.twig',
            [
                'form' => $form->createView(),
                'stop' => $stop,
            ]
        );
    }
}
