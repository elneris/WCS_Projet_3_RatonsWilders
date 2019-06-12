<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin_")
 */

class AdminController extends AbstractController
{
    /**
     * @Route("/", name="")
     * @return Response A response instance
     */
    public function index(): Response
    {
        $arrayUser = $this->getDoctrine()
            ->getRepository(User::class);

        $users = $arrayUser->findBy([], ['id' => 'DESC'], 5);

        return $this->render('Admin/index.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/rechercher", name="search")
     */
    public function search()
    {
        return $this->render('Admin/search.html.twig');
    }
}
