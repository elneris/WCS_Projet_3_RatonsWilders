<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EmailResetType;
use App\Form\ResetType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/forgot_password", name="forgot_password")
     */
    public function resetPassword(Request $request, EntityManagerInterface $entityManager, \Swift_Mailer $mailer)
    {
        $form = $this->createForm(EmailResetType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $entityManager->getRepository(User::class)
                ->findOneBy(['email' => $form->getData()['email']]);
            if ($user !== null) {
                $token = uniqid('mdp', true);
                $user->setResetToken($token);
                $user->setSentToken(new \DateTime('now'));
                $entityManager->persist($user);
                $entityManager->flush();

                $message = (new \Swift_Message('Demande de réinitialisation du mot de passe'))
                    ->setFrom('ratonsguincheur@admin.com')
                    ->setTo($user->getEmail())
                    ->setBody(
                        $this->render(
                            'emails/reset-password-mail.html.twig',
                            ['token' => $token]
                        ),
                        'text/html'
                    );
                $mailer->send($message);

                $this->addFlash(
                    'success',
                    'Un mail viens de vous être envoyé pour réinitialiser votre mot de passe'
                );

                return $this->redirectToRoute('app_login');
            }
        }

        return $this->render('authentication/reset-password.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/reset_password/{token}", name="reset_password_confirmation")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function resetPasswordToken(
        $token,
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordEncoderInterface $encoder
    ) {
        if ($token !== null) {
            $user = $entityManager->getRepository(User::class)->findOneBy(['resetToken' => $token]);

            if ($user->expiredReset() == false) {
                $this->addFlash(
                    'danger',
                    'Votre token à expiré ( 1 minute ), veuillez de nouveau réinitialiser votre mot de passe'
                );
                return $this->redirectToRoute('forgot_password');
            }

            if ($user !== null) {
                $form = $this->createForm(ResetType::class, $user);
                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()) {
                    $password = $form->getData()->getPassword();
                    $encoded = $encoder->encodePassword($user, $password);
                    $user->setPassword($encoded);
                    $user->setResetToken('');
                    $entityManager->persist($user);
                    $entityManager->flush();

                    $this->addFlash(
                        'success',
                        'Votre mot de passe à bien été modifié'
                    );

                    return $this->redirectToRoute('app_login');
                }

                return $this->render('authentication/reset-password-confirmation.html.twig', array(
                    'form' => $form->createView(),
                ));
            }
        }
    }
}
