<?php

namespace App\Controller;

use App\Entity\Style;
use App\Form\StyleType;
use App\Repository\StyleRepository;
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
     * @Route("/index/{page}", requirements={"page" = "\d+"}, name="style_index", methods={"GET"})
     */
    public function index(int $page, StyleRepository $styleRepository): Response
    {
        $maxByPage = $this->getParameter('max_page');
        $styles = $styleRepository->findAllPaginationAndTrie($page, $maxByPage);

        $pagination = [
            'page' => $page,
            'nbPages' => ceil(count($styles) / $maxByPage),
            'nameRoute' => 'style_index',
            'paramsRoute' => []
        ];

        return $this->render('style/index.html.twig', [
            'styles' => $styles,
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/ajouter", name="style_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $style = new Style();
        $form = $this->createForm(StyleType::class, $style);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($style);
            $entityManager->flush();

            return $this->redirectToRoute('style_index', ['page' => 1]);
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

        return $this->redirectToRoute('style_index', ['page' => 1]);
    }
}
