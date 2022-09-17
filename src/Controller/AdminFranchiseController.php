<?php

namespace App\Controller;

use App\Entity\Franchise;
use App\Form\FranchiseType;
use App\Entity\FranchiseSearch;
use App\Form\FranchiseSearchType;
use App\Repository\FranchiseRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[Route('/admin/franchise')]
class AdminFranchiseController extends AbstractController
{
    #[Route('/', name: 'app_admin_franchise_index', methods: ['GET'])]
    public function index(FranchiseRepository $franchiseRepository, Request $request): Response
    {
        $search = new FranchiseSearch();
        $form = $this->createForm(FranchiseSearchType::class, $search);
        $form->handleRequest($request);

        return $this->render('admin_franchise/index.html.twig', [
            'franchises' => $franchiseRepository->findAllVisible($search),
            'form' => $form->createView()
        ]);
    }

    #[Route('/new', name: 'app_admin_franchise_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FranchiseRepository $franchiseRepository, MailerInterface $mailer): Response
    {
        $franchise = new Franchise();
        $form = $this->createForm(FranchiseType::class, $franchise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $franchiseRepository->add($franchise, true);

            $email = (new Email())
            ->from('Stay@Fit.com')
            ->to($franchise->getMail())
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Votre Franchise a été créer')
            ->text('Votre franchise '. $franchise->getName(). ' a été créer')
            ->html('<p>See <b>Twig</b> integration for better HTML integration!</p>');

        $mailer->send($email);

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
