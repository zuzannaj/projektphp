<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends Controller
{
    /**
     * Index action.
     *
     * @Route("/", name="homepage")
     */
    public function index()
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * Search action.
     *
     * @Route("/searchresult", name="searchresult")
     */
    public function search()
    {
        return $this->render('home/search.html.twig', [
        'controller_name' => 'HomeController'
        ]);
    }
}
