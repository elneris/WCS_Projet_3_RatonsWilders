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
    const ALLOW_NETWORKS = ['facebook','twitter','instagram','youtube'];

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
            $found = false;

            foreach (self::ALLOW_NETWORKS as $network) {
                $regex = '/(?:https?:\/\/)?(?:www\.)?';
                $regex .= $network.'\.com\/.(?:(?:\w)*#!\/)?(?:pages\/)?(?:[\w\-]*\/)*([\w\-\.]*)/';

                $regexYoutube =  '/(https?:\/\/)?(www\.)?youtu((\.be)|(be\..{2,5}))\/((user)|(channel))\//';

                if (preg_match($regex, $link->getUrl())
                     or
                    (preg_match($regexYoutube, $link->getUrl() && $network === 'youtube'))) {
                    $found = true;

                    $link->setUrl($link->getUrl());
                    $link->setType($network);
                    $link->setUser($this->getUser());
                    $em->persist($link);
                    $em->flush();


                    $this->addFlash(
                        'success',
                        'Votre lien a bien été enregistré'
                    );

                    break;
                }
            }

            if (!$found) {
                $this->addFlash(
                    'danger',
                    'Erreur lors de l\'upload (uniquement Facebook, Twitter, Instagram, chaîne Youtube)'
                );
                return $this->redirect($this->generateUrl('socialNetwork_new'));
            }
        }

        return $this->render('link/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
