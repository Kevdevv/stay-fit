<?php

namespace App\Controller;

use App\Entity\Structure;
use App\Form\StructureType;
use App\Repository\FranchiseRepository;
use App\Repository\StructureRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

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
    public function new(Request $request, StructureRepository $structureRepository, FranchiseRepository $franchiseRepository, MailerInterface $mailer): Response
    {

        $franchise = $franchiseRepository->find($request->query->get('id'));

        $structure = new Structure();
        $structure
            ->setSellDrink($franchise->isSellDrink())
            ->setMailing($franchise->isMailing())
            ->setPromotionSalle($franchise->isPromotionSalle())
            ->setTeamPlanning($franchise->isTeamPlanning())
            ->setFranchise($franchise)
            ;

        $form = $this->createForm(StructureType::class, $structure);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $structureRepository->add($structure, true);

            $email = (new Email())
            ->from('Stay@Fit.com')
            ->to($structure->getMail())
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('La structure a été créer')
            ->html('La structure '. $structure->getName(). ' a été créer');

        $mailer->send($email);

            $emailTwo = (new Email())
            ->from('Stay@Fit.com')
            ->to($franchise->getMail())
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('La structure a été créer')
            ->html('La structure '. $structure->getName(). ' a été créer');

        $mailer->send($emailTwo);


            return $this->redirectToRoute('app_admin_franchise_index', [], Response::HTTP_SEE_OTHER);
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
    public function edit(Request $request, Structure $structure, StructureRepository $structureRepository, FranchiseRepository $franchiseRepository, MailerInterface $mailer): Response
    {
        //$franchise = $franchiseRepository->find($request->query->get('id'));

        $form = $this->createForm(StructureType::class, $structure);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $structureRepository->add($structure, true);

             $email = (new Email())
            ->from('Stay@Fit.com')
            ->to($structure->getMail())
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Des modification ont été effectué')
            ->text('Les permissions globales de votre franchise ont été modifié')
            ->html('<p>See <b>Twig</b> integration for better HTML integration!</p>');

        $mailer->send($email);

            return $this->redirectToRoute('app_admin_franchise_index', [], Response::HTTP_SEE_OTHER);
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

        return $this->redirectToRoute('app_admin_franchise_index', [], Response::HTTP_SEE_OTHER);
    }
}
