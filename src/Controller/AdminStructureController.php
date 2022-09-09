<?php

namespace App\Controller;

use App\Entity\Structure;
use App\Form\StructureType;
use App\Repository\StructureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/structure')]
class AdminStructureController extends AbstractController
{
    #[Route('/', name: 'app_admin_structure_index', methods: ['GET'])]
    public function index(StructureRepository $structureRepository): Response
    {
        return $this->render('admin_structure/index.html.twig', [
            'structures' => $structureRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_structure_new', methods: ['GET', 'POST'])]
    public function new(Request $request, StructureRepository $structureRepository): Response
    {
        $structure = new Structure();
        $form = $this->createForm(StructureType::class, $structure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $structureRepository->add($structure, true);

            return $this->redirectToRoute('app_admin_structure_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_structure/new.html.twig', [
            'structure' => $structure,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_structure_show', methods: ['GET'])]
    public function show(Structure $structure): Response
    {
        return $this->render('admin_structure/show.html.twig', [
            'structure' => $structure,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_structure_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Structure $structure, StructureRepository $structureRepository): Response
    {
        $form = $this->createForm(StructureType::class, $structure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $structureRepository->add($structure, true);

            return $this->redirectToRoute('app_admin_structure_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_structure/edit.html.twig', [
            'structure' => $structure,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_structure_delete', methods: ['POST'])]
    public function delete(Request $request, Structure $structure, StructureRepository $structureRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$structure->getId(), $request->request->get('_token'))) {
            $structureRepository->remove($structure, true);
        }

        return $this->redirectToRoute('app_admin_structure_index', [], Response::HTTP_SEE_OTHER);
    }
}