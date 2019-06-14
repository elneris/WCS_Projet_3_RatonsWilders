<?php

namespace App\Controller;

use App\Form\FilterDomainType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FilterController extends AbstractController
{
    /**
     * @Route("admin/filter", name="filter_by_domain")
     **/
    public function filterByDomain(Request $request, UserRepository $userRepository)
    {
        $searchDomainForm = $this->createForm(FilterDomainType::class);
        $users = [];

        $form = $searchDomainForm->handleRequest($request);
        if ($form->isSubmitted() && $searchDomainForm->isValid()
        ) {
            $result = $searchDomainForm->getData();
            $users = $userRepository->filterByDomain($result['name']);
        }

        return $this->render('admin/filter.html.twig', [
            'filterDomainForm' => $searchDomainForm->createView(),
            'users' => $users
            ]);
    }
}
