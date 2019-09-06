<?php

namespace App\Controller;

use App\Entity\BusRoute;
use App\Repository\BusRouteRepository;
use Knp\Component\Pager\PaginatorInterface;
use function Sodium\add;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
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
     * Index action.
     *
     * @Route("/", name="search_index")
     */
    public function search()
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('searchsearchresults'))
            ->add('query', TextType::class)
            ->add('search', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
            ->getForm();

        return $this->render('search/searchbar.html.twig', [
            'form' => $form->createView()
            ]

        );
    }

    /**
     * @Route("/searchresults", name="searchresults")
     *
     * @param Request $request
     * @param BusRouteRepository $repository
     */
    public function handleSearch(Request $request, BusRouteRepository $repository, PaginatorInterface $paginator)
    {
        $query = $request->request->get('form')['query'];

        if ($query) {
            $pagination = $paginator->paginate(
                $repository->search($query),
                $request->query->getInt('page', 1),
                BusRoute::NUMBER_OF_ITEMS);
        }

        return $this->render('search/searchresults.html.twig', [
            'pagination' => $pagination
        ]);

    }
}
