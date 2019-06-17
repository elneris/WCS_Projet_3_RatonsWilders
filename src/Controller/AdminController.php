<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserSearchType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin_")
 */

class AdminController extends AbstractController
{
    /**
     * @Route("/", name="index")
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
     * @param Request $request
     * @param UserRepository $userRepository
     * @return Response
     */
    public function search(Request $request, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserSearchType::class);
        $form->handleRequest($request);
        $users = $userRepository->searchByNames($form->getData()['searchField']);

            return $this->render(
                'Admin/search.html.twig',
                [
                    'users'=> $users,
                    'form' => $form->createView()
                ]
            );
    }
}
