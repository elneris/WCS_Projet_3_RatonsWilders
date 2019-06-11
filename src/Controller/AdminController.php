<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
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
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();

        return $this->render('Admin/index.html.twig', ['users' => $users]);
    }

    /**
     * @Route("/rechercher", name="search")
     */
    public function search()
    {
        return $this->render('Admin/search.html.twig');
    }


    /**
     * @Route("/admin", name="user_admin_index", methods={"GET"})
     */
    public function showAdmin(UserRepository $userRepository): Response
    {

        $users = $userRepository->findBy([], ['id' => 'DESC'], 5);

        return $this->render('user/index.html.twig', [
            'users' => $users
        ]);
    }
}
