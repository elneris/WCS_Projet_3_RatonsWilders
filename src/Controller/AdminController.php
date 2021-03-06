<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AdminType;
use App\Form\SearchType;
use App\Repository\MediaRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
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
     * @Route("/liste-admin", name="show_admin" )
     * @param UserRepository $userRepository
     * @return Response
     */
    public function showAdmin(Request $request, UserRepository $userRepository): Response
    {
        $filter = $this->createForm(AdminType::class);
        $users = $userRepository->findBy([], ['admin' => 'DESC', 'email' => 'ASC']);

        $form = $filter->handleRequest($request);

        if ($form->isSubmitted() && $filter->isValid()) {
            $users = $userRepository->adminFilter($filter->getData());
        }

        return $this->render('admin/listAdmin.html.twig', [
            'filterDomainForm' => $filter->createView(),
            'users' => $users,
        ]);
    }

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
     * @Route("/rechercher", name="search")
     * @param Request $request
     * @param UserRepository $userRepository
     * @return Response
     */
    public function search(Request $request, UserRepository $userRepository)
    {
        $filter = $this->createForm(SearchType::class);
        $users = [];

        $form = $filter->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $users = $userRepository->myFilter($form->getData());
        }

        return $this->render('admin/search.html.twig', [
            'filterDomainForm' => $filter->createView(),
            'users' => $users
        ]);
    }

    /**
     * @Route("/{id}", name="user_show")
     * @param User $user
     * @return Response
     */
    public function show(int $id, User $user, MediaRepository $mediaRepository): Response
    {
        $avatar = null;

        if (!empty($mediaRepository->findLastAvatar($id))) {
            $avatar = $mediaRepository->findLastAvatar($id);
        }

        return $this->render('user/show.html.twig', [
            'user' => $user,
            'avatar' => $avatar,
        ]);
    }

    /**
     * @Route("/{id}/changement-role", name="change_role")
     * @param int $id
     * @param UserRepository $userRepository
     * @param EntityManagerInterface $entityManager
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function changeRole(int $id, UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        $actualUser = $this->getUser();
        $user = $userRepository->find($id);
        if ($actualUser !== $user) {
            if (($user->getRoles()[0] == 'ROLE_ADMIN')) {
                $user->setRoles(['ROLE_USER']) ;
                $user->setAdmin(false) ;
            } else {
                $user->setRoles(['ROLE_ADMIN']) ;
                $user->setAdmin(true) ;
            }
            $entityManager->flush();
        }


        return $this->json([
            'isAdmin' => $user->isAdmin()
        ]);
    }
}
