<?php

namespace App\Controller;

use App\Entity\ComedyClub;
use App\Form\ComedyClubType;
use App\Repository\ComedyClubRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/comedy/club')]
class ComedyClubController extends AbstractController
{
    #[Route('/', name: 'app_comedy_club_index', methods: ['GET'])]
    public function index(ComedyClubRepository $comedyClubRepository): Response
    {
        return $this->render('comedy_club/index.html.twig', [
            'comedy_clubs' => $comedyClubRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_comedy_club_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $comedyClub = new ComedyClub();
        $form = $this->createForm(ComedyClubType::class, $comedyClub);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($comedyClub);
            $entityManager->flush();

            return $this->redirectToRoute('app_comedy_club_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('comedy_club/new.html.twig', [
            'comedy_club' => $comedyClub,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_comedy_club_show', methods: ['GET'])]
    public function show(ComedyClub $comedyClub): Response
    {
        return $this->render('comedy_club/show.html.twig', [
            'comedy_club' => $comedyClub,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_comedy_club_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ComedyClub $comedyClub, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ComedyClubType::class, $comedyClub);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_comedy_club_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('comedy_club/edit.html.twig', [
            'comedy_club' => $comedyClub,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_comedy_club_delete', methods: ['POST'])]
    public function delete(Request $request, ComedyClub $comedyClub, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$comedyClub->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($comedyClub);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_comedy_club_index', [], Response::HTTP_SEE_OTHER);
    }
}
