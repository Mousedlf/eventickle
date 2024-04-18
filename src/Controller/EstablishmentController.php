<?php

namespace App\Controller;

use App\Entity\Establishment;
use App\Entity\User;
use App\Form\EstablishmentType;
use App\Repository\EstablishmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
#[Route('/api/establishment')]
class EstablishmentController extends AbstractController
{
    #[Route('s', name: 'app_establishment_index', methods: ['GET'])]
    public function index(EstablishmentRepository $establishmentRepository): Response
    {

        $establishments = $establishmentRepository->findAll();
        return $this->json($establishments, Response::HTTP_OK, [], ['groups' => ['establishment:read']]);
    }

    #[Route('/establishment/new/{id}', name: 'app_establishment_new', methods: ['POST'])]
    public function new(
        User $user,
        Request $request,
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer): Response
    {
        $establishment = $serializer->deserialize($request->getContent(), Establishment::class, 'json');
        $serializer->setOfUser($user);
        $entityManager->persist($establishment);
        $entityManager->flush();
        return $this->json($establishment, Response::HTTP_CREATED, [], ["groups"=>"establishment:read"]);
    }

    #[Route('/{id}', name: 'app_establishment_show', methods: ['GET'])]
    public function show(Establishment $establishment): Response
    {
        return $this->json($establishment, Response::HTTP_OK, [], ['groups'=>['establishment:read']]);
    }

    #[Route('/{id}/edit', name: 'app_establishment_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Establishment $establishment,
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer
    ): Response
    {



    }

    #[Route('/{id}', name: 'app_establishment_delete', methods: ['POST'])]
    public function delete(Request $request, Establishment $establishment, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$establishment->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($establishment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_establishment_index', [], Response::HTTP_SEE_OTHER);
    }
}
