<?php
/**
 * Stop controller.
 */

namespace App\Controller;

use App\Entity\Stop;
use App\Repository\StopRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class StopController.
 *
 * @Route("/stop")
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
     *     name="test_index"
     * )
     */
    public function index(StopRepository $repository): Response
    {
        return $this->render(
            'stop/index.html.twig',
            ['data' => $repository->findAll()]
        );
    }
}