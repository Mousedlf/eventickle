<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Order;
use App\Entity\Ticket;
use App\Repository\EventRepository;
use App\Service\QRCodeService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;


#[Route('/api/order')]
class OrderController extends AbstractController
{
    #[Route('/all', name: 'app_order')]
    public function index(): Response
    {
        return $this->render('order/index.html.twig', [
            'controller_name' => 'OrderController',
        ]);
    }



    #[Route('/make/{id}', name: 'make', methods: ['POST'])]
    public function makeOrder(Request $request, Event $event, SerializerInterface $serializer, EntityManagerInterface $entityManager, EventRepository $repository): Response{
        $order = $serializer->deserialize($request->getContent(), Order::class, 'json');
        $order->setMadeBy($this->getUser());


        for ($i = 0; $i < $order->getNumberOfPersons(); $i++) {
            $ticket = new Ticket();
            $ticket->setEvent($event);
            $ticket->setBoughtBy($this->getUser()->getSpectator());
            $ticket->setCreatedAt(new \DateTimeImmutable());
            $ticket->setSpectator($this->getUser()->getSpectator());
            $ticket->setUsed(false);
            $ticket->setPrice($event->getPrice());
            $ticket->setQrCode("lallajesuisunqrcode");
            $entityManager->persist($ticket);
            $order->addTicket($ticket);
        }
        $entityManager->persist($order);
        $entityManager->flush();
        return $this->json($order, Response::HTTP_CREATED, [], ['groups' => ['order:read']]);
    }
}
