<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/api/current/user', name: 'login')]
    public function getCurrentUserInfo(UserRepository $userRepository): Response
    {

        $currentUserRole = $this->getUser()->getRoles()[0];


        if($currentUserRole === 'ROLE_COMEDIAN') {
           $role = "comedian";
           $roleId= $this->getUser()->getComedian()->getId();
        }
        else if($currentUserRole === 'ROLE_CLUB') {
            $role = "club";
            $roleId= $this->getUser()->getClub()->getId();
        }
        else if($currentUserRole === 'ROLE_SPECTATOR') {
            $role = "spectator";
            $roleId= $this->getUser()->getSpectator()->getId();
        }
        else if($currentUserRole === 'ROLE_ESTABLISHMENT') {
            $role = "establishment";
            $roleId= $this->getUser()->getEstablishment()->getId();
        }

        

        $response = [
            "role" => $role,
            "roleId"=> $roleId
        ];


        return $this->json($response, Response::HTTP_OK);

    }






    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, Request $request): Response
    {

        if(
            $this->getUser()->getComedian() == null
            OR $this->getUser()->getSpectator() == null
            OR $this->getUser()->getEstablishment() == null
            OR $this->getUser()->getComedyClub() == null
        ){
            return $this->json("/".$this->getUser()->getRoles()[0]."/new/".$this->getUser()->getId(), Response::HTTP_UNAUTHORIZED);
        }


        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #
}
