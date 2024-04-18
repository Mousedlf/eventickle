<?php

namespace App\Controller;

use App\Entity\Invite;
use App\Repository\ComedianRepository;
use App\Repository\EstablishmentRepository;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/api/invitation')]
class InvitationController extends AbstractController
{
    #[Route('s', name: 'app_invitation')]
    public function index(): Response
    {
        return $this->render('invitation/index.html.twig', [
            'controller_name' => 'InvitationController',
        ]);
    }

    #[Route('/sendto/comedian/{id}', name: 'app_invitation_send_to_comedian')]
    #[Route('/sendto/establishment/{id}', name: 'app_invitation_send_to_establishment')]
    public function sendInvite($id, Request $request, ComedianRepository $comedianRepository, EstablishmentRepository $establishmentRepository, EntityManagerInterface $manager, EventRepository $eventRepository): Response{
        $route = $request->attributes->get('_route');
        $invite = new Invite();
        $invite->setEvent($eventRepository->find($request->getPayload()->get("event")));
        $invite->setStatus(false);
        $invite->setComedyClub($this->getUser()->getComedyClub());
        if ($route == "app_invitation_send_to_comedian"){
            $tmpComedian = $comedianRepository->find($id);
            if (!$tmpComedian){
                return $this->json("Comedian not found");
            }
            $invite->setSentToComedian($tmpComedian);
        }else{
            $tmpEstablishment = $establishmentRepository->find($id);
            if (!$tmpEstablishment){
                return $this->json("Establishment not found");
            }
            $invite->setSentToEstablishment($tmpEstablishment);
        }
        $manager->persist($invite);
        $manager->flush();
        return $this->json($invite, Response::HTTP_OK, [], ['groups' => ['invitation:read', 'establishment:read', 'comedian:read']]);
    }


//    #[Route('/accept/{id}', name: 'app_invitation_accept')]
//    public function accetpInvite(Invite $invite){
//        if(!$invite){
//            return $this->json("Invitation not found", Response::HTTP_NOT_FOUND);
//        }
//        if ($invite->getSentToComedian()){
//
//        }else{
//
//        }
//    }
}
