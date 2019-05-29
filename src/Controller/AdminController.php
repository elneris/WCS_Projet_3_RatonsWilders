<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin_")
 */

class AdminController extends AbstractController
{
    /**
     * @Route("/", name="")
     */
    public function index()
    {
        return $this->render('Admin/index.html.twig');
    }

    /**
     * @Route("/rechercher", name="search")
     */
    public function search()
    {
        return $this->render('Admin/search.html.twig');
    }
}
