<?php

namespace App\Controller;

use App\Entity\Style;
use App\Form\StyleType;
use App\Repository\StyleRepository;
use App\Services\ActivityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/style")
 */
class StyleController extends AbstractController
{
    /**
     * @Route("/index", name="style_index", methods={"GET"})
     */
    public function index(StyleRepository $styleRepository): Response
    {
        return $this->render('style/index.html.twig', [
            'styles' => $styleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/ajouter", name="style_new", methods={"GET","POST"})
     */
    public function new(Request $request, ActivityManager $activityManager): Response
    {
        $style = new Style();
        $form = $this->createForm(StyleType::class, $style);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($activityManager->styleExist($style)) {
                $this->addFlash(
                    'danger',
                    'L\'accessoire exist déjà'
                );
            } else {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($style);
                $entityManager->flush();

                $this->addFlash(
                    'success',
                    'Le style a bien été ajouté'
                );

                return $this->redirectToRoute('style_index');
            }
        }

        return $this->render('style/new.html.twig', [
            'style' => $style,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="style_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Style $style): Response
    {
        $form = $this->createForm(StyleType::class, $style);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('style_index', [
                'id' => $style->getId(),
            ]);
        }

        return $this->render('style/edit.html.twig', [
            'style' => $style,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="style_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Style $style): Response
    {
        if ($this->isCsrfTokenValid('delete'.$style->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($style);
            $entityManager->flush();
        }

        return $this->redirectToRoute('style_index');
    }
}
