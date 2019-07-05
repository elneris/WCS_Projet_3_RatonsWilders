<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\FilterType;
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
     * @param UserRepository $userRepository
     * @return Response A response instance
     */
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findLastTenUsers();

        return $this->render('admin/index.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/filtrer", name="filter")
     * @param Request $request
     * @param UserRepository $userRepository
     * @return Response
     */
    public function filter(Request $request, UserRepository $userRepository)
    {
        $filter = $this->createForm(FilterType::class);
        $users = [];

        $form = $filter->handleRequest($request);

        if ($form->isSubmitted() && $filter->isValid()) {
            $users = $userRepository->myFilter($filter->getData());
        }

        return $this->render('admin/filter.html.twig', [
            'filterDomainForm' => $filter->createView(),
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
            'admin/search.html.twig',
            [
                'users' => $users,
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/{id}", name="user_show")
     * @param User $user
     * @return Response
     */
    public function show(User $user): Response
    {
        return $this->render('admin/show.html.twig', [
            'user' => $user

        ]);
    }
}
