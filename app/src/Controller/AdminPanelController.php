<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
}
