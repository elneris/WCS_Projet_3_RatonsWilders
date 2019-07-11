<?php

namespace App\Controller;

use App\Entity\Skill;
use App\Form\SkillType;
use App\Repository\SkillRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/accesoire")
 */
class SkillController extends AbstractController
{
    /**
     * @Route("/index/{page}", requirements={"page" = "\d+"}, name="skill_index", methods={"GET"})
     */
    public function index(int $page, SkillRepository $skillRepository): Response
    {
        $maxByPage = $this->getParameter('max_page');
        $skills = $skillRepository->findAllPaginationAndTrie($page, $maxByPage);

        $pagination = [
            'page' => $page,
            'nbPages' => ceil(count($skills) / $maxByPage),
            'nameRoute' => 'skill_index',
            'paramsRoute' => []
        ];

        return $this->render('skill/index.html.twig', [
            'skills' => $skills,
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/ajouter", name="skill_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $skill = new Skill();
        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($skill);
            $entityManager->flush();

            return $this->redirectToRoute('skill_index', ['page' => 1]);
        }

        return $this->render('skill/new.html.twig', [
            'skill' => $skill,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/editer", name="skill_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Skill $skill): Response
    {
        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('skill_index', [
                'id' => $skill->getId(),
            ]);
        }

        return $this->render('skill/edit.html.twig', [
            'skill' => $skill,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="skill_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Skill $skill): Response
    {
        if ($this->isCsrfTokenValid('delete'.$skill->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($skill);
            $entityManager->flush();
        }

        return $this->redirectToRoute('skill_index', ['page' => 1]);
    }
}
