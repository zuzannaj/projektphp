<?php

namespace App\Controller;

use App\Entity\BusRoute;
use App\Repository\BusRouteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\HttpFoundation\Request;
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

}
