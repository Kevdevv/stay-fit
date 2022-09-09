<?php

namespace App\Controller;

use App\Entity\Franchise;
use App\Form\FranchiseType;
use App\Repository\FranchiseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/franchise')]
class AdminFranchiseController extends AbstractController
{
    #[Route('/', name: 'app_admin_franchise_index', methods: ['GET'])]
    public function index(FranchiseRepository $franchiseRepository): Response
    {
        return $this->render('admin_franchise/index.html.twig', [
            'franchises' => $franchiseRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_franchise_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FranchiseRepository $franchiseRepository): Response
    {
        $franchise = new Franchise();
        $form = $this->createForm(FranchiseType::class, $franchise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $franchiseRepository->add($franchise, true);

            return $this->redirectToRoute('app_admin_franchise_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_franchise/new.html.twig', [
            'franchise' => $franchise,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_franchise_show', methods: ['GET'])]
    public function show(Franchise $franchise): Response
    {
        return $this->render('admin_franchise/show.html.twig', [
            'franchise' => $franchise,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_franchise_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Franchise $franchise, FranchiseRepository $franchiseRepository): Response
    {
        $form = $this->createForm(FranchiseType::class, $franchise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $franchiseRepository->add($franchise, true);

            return $this->redirectToRoute('app_admin_franchise_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_franchise/edit.html.twig', [
            'franchise' => $franchise,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_franchise_delete', methods: ['POST'])]
    public function delete(Request $request, Franchise $franchise, FranchiseRepository $franchiseRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$franchise->getId(), $request->request->get('_token'))) {
            $franchiseRepository->remove($franchise, true);
        }

        return $this->redirectToRoute('app_admin_franchise_index', [], Response::HTTP_SEE_OTHER);
    }
}
