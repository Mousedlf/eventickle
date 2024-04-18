<?php

namespace App\Controller;

use App\Entity\Spectator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;


#[Route('/api/spectator')]
class SpectatorController extends AbstractController
{
    #[Route('/{id}/tickets', name: 'app_spectator')]
    public function index(): Response
    {
        return $this->render('spectator/index.html.twig', [
            'controller_name' => 'SpectatorController',
        ]);
    }


    #[Route('/new', name:'app_spectator_new', methods: ['GET', 'POST'])]
    public function new(Request $request , EntityManagerInterface $entityManager, SerializerInterface $serializer): Response{
        $spectator = $serializer->deserialize($request->getContent(), Spectator::class, 'json');
        $spectator->setOfUser($this->getUser());
        $entityManager->persist($spectator);
        $entityManager->flush();
        return $this->json($spectator, Response::HTTP_CREATED, [], ['groups' => 'spectator:read']);
    }
}
