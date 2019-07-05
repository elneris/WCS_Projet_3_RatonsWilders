<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\Link;
use App\Entity\Media;
use App\Entity\User;
use App\Form\ChangePasswordType;
use App\Form\LinkType;
use App\Form\UserType;
use App\Form\ActivityType;
use App\Repository\MediaRepository;
use App\Repository\UserRepository;
use App\Services\ActivityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/utilisateur", name="user_")
 */
class UserController extends AbstractController
{

    /**
     * @Route("/", name="index", methods={"GET"})
     * @return Response
     */
    public function index(MediaRepository $mediaRepository): Response
    {

        $user = $this->getUser();

        if (!$user->getEnable()) {
            $this->addFlash(
                'danger',
                'Votre compte n\'est pas validé, merci de vérifier vos emails'
            );

            return $this->redirectToRoute('user_validation');
        }

        $id = $this->getUser()->getId();
        $avatar = null;

        if (!empty($mediaRepository->findLastAvatar($id))) {
            $avatar = $mediaRepository->findLastAvatar($id);
        }

        return $this->render('user/show.html.twig', [
            'avatar' => $avatar
        ]);
    }

    /**
     * @ROUTE("/validation", name="validation")
     */
    public function show()
    {
        return $this->render('security/validation_mail.html.twig');
    }

    /**
     * @Route("/nouvel-utilisateur", name="new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edition", name="edit", methods={"GET","POST"})
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function edit(Request $request, User $user): Response
    {

        $form = $this->createForm(UserType::class, $user);
        $form->remove('password');
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $this->getDoctrine()->getManager()->persist($user);
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('user_index', [
                    'id' => $user->getId(),
                ]);
            } else {
                $this->addFlash('danger', 'L\'un des champs renseigné n\'est pas valide');
            }
        }
        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/ajout-activite", name="add_activity", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */

    public function addActivity(Request $request, ActivityManager $activityManager): Response
    {
        $activity = new Activity();
        $user = $this->getUser();

        $form = $this->createForm(ActivityType::class, $activity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($activityManager->activityExists($activity, $user)) {
                $this->addFlash(
                    'danger',
                    'Votre activité existe déjà'
                );
            } else {
                $activity->setUser($user);

                $this->getDoctrine()->getManager()->persist($activity);
                $this->getDoctrine()->getManager()->flush();

                $this->addFlash(
                    'success',
                    'Votre activité a bien été ajoutée'
                );
            }
            return $this->redirectToRoute('user_add_activity', [
                'id' => $user->getId(),
            ]);
        }
        return $this->render('user/add_activity.html.twig', [
            'activity' => $activity,
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edition-liens", name="edit_links", methods={"GET","POST"})
     * @param Request $request
     * @param Link $links
     * @param User $user
     * @return Response
     */

    public function editLinks(Request $request, Link $links, User $user): Response
    {
        $form = $this->createForm(LinkType::class, $links);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->persist($links);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index', [
                'id' => $links->getId(),
            ]);
        }

        return $this->render('user/edit_links.html.twig', [
            'links' => $links,
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/changement-mot-de-passe", methods={"GET", "POST"}, name="change_password")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */

    public function changePassword(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($encoder->encodePassword($user, $form->get('newPassword')->getData()));
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash(
                'success',
                'Votre mot de passe a bien été modifié'
            );
            return $this->redirectToRoute('user_index');
        }
        return $this->render('user/change_password.html.twig', [
            'form' => $form->createView(),

        ]);
    }

    /**
     * @Route("/supprimer-activite/{id}", name="delete_activity")
     * @param Activity $activity
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteActivity(Activity $activity, EntityManagerInterface $em, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $activity->getId(), $request->request->get('_token'))) {
            $em->remove($activity);
            $em->flush();

            $this->addFlash(
                'success',
                'Vous avez bien supprimé cette activité'
            );
        }

        return $this->redirectToRoute('user_index');
    }
}
