<?php

namespace App\Controller;

use App\Entity\ComedyClub;
use App\Entity\User;
use App\Form\ComedyClubType;
use App\Repository\ComedyClubRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/comedy/club')]
class ComedyClubController extends AbstractController
{


    #[Route('/new', name: 'app_comedy_club_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        $comedyClub = $serializer->deserialize($request->getContent(), ComedyClub::class, 'json');
        $comedyClub->setOfUser($this->getUser());
        $entityManager->persist($comedyClub);
        $entityManager->flush();
        return $this->json($comedyClub, Response::HTTP_CREATED, [], ["groups" => "comedy-club:read"]);
    }

    #[Route('/{id}', name: 'app_comedy_club_show', methods: ['GET'])]
    public function show(ComedyClub $comedyClub): Response
    {
        return $this->json($comedyClub, Response::HTTP_OK,[], ['groups' => 'comedy-club:read']);
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
