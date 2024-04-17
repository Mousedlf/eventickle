<?php

namespace App\Controller;

use App\Entity\Comedian;
use App\Entity\User;
use App\Form\ComedianType;
use App\Repository\ComedianRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;


class ComedianController extends AbstractController
{
    #[Route('/comedians', name: 'app_comedian_index', methods: ['GET'])]
    public function index(ComedianRepository $comedianRepository): Response
    {
        $comedians = $comedianRepository->findAll();

        return $this->json($comedians, Response::HTTP_OK, [], ['groups' => ['comedian:read']]);
    }

    #[Route('/comedian/new/{id}', name: 'app_comedian_new', methods: ['GET', 'POST'])]
    public function new(User $user, Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        $comedian = $serializer->deserialize($request->getContent(), Comedian::class, 'json');
        $comedian->setOfUser($user);
        $entityManager->persist($comedian);
        $entityManager->flush();

        return $this->json($comedian, Response::HTTP_CREATED, [], ['groups' => ['comedian:read']]);
    }

    #[Route('/comedian/{id}', name: 'app_comedian_show', methods: ['GET'])]
    public function show(Comedian $comedian): Response
    {
        return $this->json($comedian, Response::HTTP_OK, [], ['groups' => ['comedian:read']]);
    }

    #[Route('/api/comedian/{id}/edit', name: 'app_comedian_edit', methods: ['PUT'])]
    public function edit(
        Request $request,
        Comedian $comedian,
        EntityManagerInterface $manager,
        SerializerInterface $serializer
    ): Response
    {
        if($this->getUser()->getComedian() != $comedian){
            return $this->json("you can't edit other comedians profiles", Response::HTTP_FORBIDDEN);
        }

        $editedComedian = $serializer->deserialize($request->getContent(), Comedian::class, 'json');
        $manager->persist($editedComedian);
        $manager->flush();

        return $this->json($editedComedian, Response::HTTP_OK, [], ['groups' => ['comedian:read']]);


    }

    #[Route('/{id}', name: 'app_comedian_delete', methods: ['POST'])]
    public function delete(Request $request, Comedian $comedian, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$comedian->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($comedian);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_comedian_index', [], Response::HTTP_SEE_OTHER);
    }
}
