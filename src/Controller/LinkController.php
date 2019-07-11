<?php

namespace App\Controller;

use App\Entity\Link;
use App\Form\LinkType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LinkController extends AbstractController
{

    /**
     * @Route("/nouveau-lien", name="socialNetwork_new", methods={"GET","POST"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function newSocialNetwork(Request $request, EntityManagerInterface $em): Response
    {
        $link = new Link();
        $form = $this->createForm(LinkType::class, $link);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (preg_match(
                ' /(?:https?:\/\/)?(?:www\.)?facebook\.com\/.(?:(?:\w)*#!\/)?(?:pages\/)?(?:[\w\-]*\/)*([\w\-\.]*)/ ',
                $link->getUrl()
            )) {
                $link->setUrl($link->getUrl());
                $link->setType('facebook');
                $link->setUser($this->getUser());
                $em->persist($link);
                $em->flush();

                $this->addFlash(
                    'success',
                    'Votre lien a bien été enregistré'
                );
            } elseif (preg_match(
                ' /(?:https?:\/\/)?(?:www\.)?twitter\.com\/.(?:(?:\w)*#!\/)?(?:pages\/)?(?:[\w\-]*\/)*([\w\-\.]*)/ ',
                $link->getUrl()
            )) {
                $link->setUrl($link->getUrl());
                $link->setType('twitter');
                $link->setUser($this->getUser());
                $em->persist($link);
                $em->flush();

                $this->addFlash(
                    'success',
                    'Votre lien a bien été enregistré'
                );
            } elseif (preg_match(
                ' /(?:https?:\/\/)?(?:www\.)?instagram\.com\/.(?:(?:\w)*#!\/)?(?:pages\/)?(?:[\w\-]*\/)*([\w\-\.]*)/ ',
                $link->getUrl()
            )) {
                $link->setUrl($link->getUrl());
                $link->setType('instagram');
                $link->setUser($this->getUser());
                $em->persist($link);
                $em->flush();

                $this->addFlash(
                    'success',
                    'Votre lien a bien été enregistré'
                );
            } elseif (preg_match(
                '/(https?:\/\/)?(www\.)?youtu((\.be)|(be\..{2,5}))\/((user)|(channel))\//',
                $link->getUrl()
            )) {
                $link->setUrl($link->getUrl());
                $link->setType('youtube');
                $link->setUser($this->getUser());
                $em->persist($link);
                $em->flush();

                $this->addFlash(
                    'success',
                    'Votre lien a bien été enregistré'
                );
            } else {
                $this->addFlash(
                    'danger',
                    'Erreur lors de l\'upload (uniquement Facebook, Twitter, Instagram, chaîne Youtube)'
                );
                $this->redirect($this->generateUrl('socialNetwork_new'));
            }
        }

        return $this->render('link/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
