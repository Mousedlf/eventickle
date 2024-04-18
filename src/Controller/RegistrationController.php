<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, SerializerInterface $serializer, UserRepository $repository): Response
    {
        $user = $serializer->deserialize($request->getContent(), User::class, 'json');
        if($repository->findBy(["email"=>$user->getEmail()])){
            return $this->json("User already exist !", Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $tmprole = $user->getRoles()[0];
        $user->setRoles(["ROLE_".strtoupper($tmprole)]);
        // encode the plain password
        $user->setPassword(
            $userPasswordHasher->hashPassword(
                $user,
                $user->getPassword()
            )
        );
        $entityManager->persist($user);
        $entityManager->flush();

        $url = "/".$tmprole."/new"; //.$user->getId()
        
        return $this->json($url, Response::HTTP_CREATED);
    }
}
