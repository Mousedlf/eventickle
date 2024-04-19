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

        $role = strtolower(substr($currentUserRole, 5));
        $method = "get".ucfirst($role);

        $method = $this->getUser()->$method();
        if (!$method){
            return $this->json($currentUserRole);
        }

        $response = [
            "role" => $role,
            "roleId"=> $method->getId()
        ];

        return $this->json($response, Response::HTTP_OK);

    }



    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, Request $request): Response
    {

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #
}
