<?php

namespace App\Controller;

use App\Entity\Media;
use App\Entity\Token;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Services\TokenManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/inscription", name="app_register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param TokenManager $tokenManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function register(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        TokenManager $tokenManager
    ) {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setRoles(["ROLE_USER"]);
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $token = new Token($user);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($token);
            $media = new Media();
            $media->setName('MonAvatar');
            $media->setUrl('assets/img/avatar.jpg');
            $media->setType('avatar');
            $media->setUser($user);

            $entityManager->persist($media);

            $entityManager->flush();

            $tokenManager->send($user, $token);

            $this->addFlash(
                'success',
                "Un email de confirmation vous a été envoyé, veuillez cliquer sur le lien présent dans l'email"
            );

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/confirmation/{value}", name="token_validation")
     *
     */
    public function validateToken(Token $token, EntityManagerInterface $manager, Request $request)
    {
        $user = $token->getUser();

        if ($user->getEnable()) {
            $this->addFlash(
                'danger',
                "Cette clé de validation est déjà validée !"
            );

            return $this->redirectToRoute('app_login');
        }

        if ($token->isValid()) {
            $user->setEnable(true);
            $manager->flush();

            $this->addFlash(
                'success',
                "Votre inscription a bien été validée, vous pouvez vous connecter !"
            );

            return $this->redirectToRoute('app_login');
        }

        $manager->remove($token);
        $manager->flush();

        $this->addFlash(
            'notice',
            "La clé de validation est expirée, inscrivez-vous à nouveau"
        );

        return $this->redirectToRoute('app_register');
    }
}
