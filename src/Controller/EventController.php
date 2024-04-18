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
    #[Route('/', name: 'app_event_index', methods: ['GET'])]
    public function index(EventRepository $eventRepository): Response
    {
        return $this->render('event/index.html.twig', [
            'events' => $eventRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_event_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer, ComedianRepository $comedianRepository): Response
    {
        $event = $serializer->deserialize($request->getContent(), Event::class, 'json');
        $event->setComedyClub($this->getUser()->getComedyClub());
        $event->setStatus(false);

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
    public function edit(Request $request, Event $event, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_event_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('event/edit.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
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
