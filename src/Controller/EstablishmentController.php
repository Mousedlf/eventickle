<?php

namespace App\Controller;

use App\Entity\Establishment;
use App\Entity\User;
use App\Form\EstablishmentType;
use App\Repository\EquipmentRepository;
use App\Repository\EstablishmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
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

    #[Route('/new', name: 'app_establishment_new', methods: ['POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
        EquipmentRepository $equipmentRepository
    ): Response
    {
        if(in_array("ROLE_ESTABLISHMENT", $this->getUser()->getRoles())){
            return $this->json('you are not logged in as an establishment');
        }

        $establishment = $serializer->deserialize($request->getContent(), Establishment::class, 'json');

        $establishment->setOfUser($this->getUser());

        $req= json_decode($request->getContent(), true);
        foreach($req["equipmentIds"] as $equipmentId){

            $equipment = $equipmentRepository->findBy(['id' => $equipmentId]);

            if(!$equipment){
                return $this->json($equipmentId." doesn't exist", Response::HTTP_NOT_FOUND);
            }

            if($establishment->getEquipments()->contains($equipment)){
                return $this->json($equipmentId." already added", Response::HTTP_NOT_FOUND);
            }

            $establishment->addEquipment($equipment[0]);

        }

        $entityManager->persist($establishment);
        $entityManager->flush();

        return $this->json($establishment, Response::HTTP_CREATED, [], ["groups"=>"establishment:read"]);
    }

    #[Route('/{id}', name: 'app_establishment_show', methods: ['GET'])]
    public function show(Establishment $establishment): Response
    {
        return $this->json($establishment, Response::HTTP_OK, [], ['groups'=>['establishment:read']]);
    }

    #[Route('/{id}/edit', name: 'app_establishment_edit', methods: ['POST'])] // ROUTE A COMBINER AVEC NEW
    public function edit(
        Request $request,
        Establishment $establishment,
        EntityManagerInterface $manager,
        SerializerInterface $serializer,
        EquipmentRepository $equipmentRepository
    ): Response
    {

        if($this->getUser()->getEstablishment() != $establishment){
            return $this->json("you can't edit other comedians profiles", Response::HTTP_FORBIDDEN);
        }

        $editedEstablishment = $serializer->deserialize($request->getContent(), Establishment::class, 'json');

        $req= json_decode($request->getContent(), true);
        foreach($req["equipmentIds"] as $equipmentId){

            $equipment = $equipmentRepository->findBy(['id' => $equipmentId]);

            if(!$equipment){
                return $this->json($equipmentId." doesn't exist", Response::HTTP_NOT_FOUND);
            }

            if($establishment->getEquipments()->contains($equipment)){
                return $this->json($equipmentId." already added", Response::HTTP_NOT_FOUND);
            }

            $editedEstablishment->addEquipment($equipment[0]);

        }

        $manager->persist($editedEstablishment);
        $manager->flush();

        return $this->json($editedEstablishment, Response::HTTP_OK, [], ['groups'=>['establishment:read']]);


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
