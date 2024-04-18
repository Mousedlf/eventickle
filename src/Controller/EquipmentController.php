<?php

namespace App\Controller;

use App\Entity\Equipment;
use App\Form\EquipmentType;
use App\Repository\EquipmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/equipment')]
class EquipmentController extends AbstractController
{
    #[Route('s', name: 'app_equipment_index', methods: ['GET'])]
    public function index(EquipmentRepository $equipmentRepository): Response
    {
        $equipments = $equipmentRepository->findAll();
        return $this->json($equipments, Response::HTTP_OK, [], ['groups' => ['equipment:read']]);

    }


    // servait a rien de faire routes ci-dessous en API
    // caro

    #[Route('/new', name: 'app_equipment_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $manager,
        SerializerInterface $serializer,
    ): Response
    {

        $equipment = $serializer->deserialize($request->getContent(), Equipment::class, 'json');
        $manager->persist($equipment);
        $manager->flush();

        return $this->json($equipment, Response::HTTP_CREATED, [], ['groups' => ['equipment:read']]);

    }

    #[Route('/{id}', name: 'app_equipment_show', methods: ['GET'])]
    public function show(Equipment $equipment): Response
    {
       return $this->json($equipment, Response::HTTP_OK, [], ['groups' => ['equipment:read']]);
    }

    #[Route('/{id}/edit', name: 'app_equipment_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Equipment $equipment, EntityManagerInterface $entityManager): Response
    {

    }

    #[Route('/{id}/remove', name: 'app_equipment_edit', methods: ['GET', 'POST'])]
    public function remove(Request $request, Equipment $equipment, EntityManagerInterface $manager): Response
    {
        $manager->remove($equipment);
        $manager->flush();

        return $this->json('equipment removed', Response::HTTP_NO_CONTENT);
    }

}
