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
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request    HTTP request
     * @param \App\Repository\StopRepository            $repository Stop repository
     * @param \App\Entity\Stop                          $stop       Stop entity
     *
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
     *     name="stop_delete",
     * )
     */
    public function delete(Request $request, StopRepository $repository, Stop $stop): Response
    {
        //$stop = $repository->find($id);
        $form = $this->createForm(StopType::class, $stop, ['method' => 'DELETE']);
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
}