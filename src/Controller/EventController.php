<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\ComedianRepository;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/event')]
class EventController extends AbstractController
{
    #[Route('/all', name: 'app_event_index', methods: ['GET'])]
    public function index(EventRepository $eventRepository): Response
    {
        return $this->json($eventRepository->findAll());
    }

    #[Route('/{id}/validate', name: 'app_event_validate', methods: ['POST'])]
    public function validateEvent(Event $event, Request $request, SerializerInterface $serializer): Response
    {
        $event->setStatus(2);
        return $this->json("event validé");
    }
    #[Route('/new', name: 'app_event_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        $event = $serializer->deserialize($request->getContent(), Event::class, 'json');
        $event->setComedyClub($this->getUser()->getComedyClub());
        $event->setStatus(0);

        // ajout verif pour pas avoir 2 specatcles du meme nom/date/lieu

        $event->setCreatedAt(new \DateTimeImmutable());
        $entityManager->persist($event);
        $entityManager->flush();
        return $this->json($event, Response::HTTP_CREATED, [], ["groups"=>"event:read"]);
    }

    #[Route('/{id}', name: 'app_event_show', methods: ['GET'])]
    public function show(Event $event): Response
    {
        return $this->json($event, Response::HTTP_OK, [], ["groups"=>"event:read"]);
    }

    #[Route('/{id}/edit', name: 'app_event_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Event $event,
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer): Response
    {
        // ajour if

        $editedEvent = $serializer->deserialize($request->getContent(), Event::class, 'json');
        $entityManager->persist($editedEvent);
        $entityManager->flush();
    }

    #[Route('/{id}/delete', name: 'app_event_delete', methods: ['DELETE'])]
    public function delete(Event $event, EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser()->getEvent() != $event) {
            return $this->json("you can't edit other event profiles", Response::HTTP_FORBIDDEN);
        }

        $entityManager->remove($event);
        $entityManager->flush();

        return $this->json('Event deleted', Response::HTTP_SEE_OTHER);
    }





}
