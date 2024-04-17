<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
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
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        $user = $serializer->deserialize($request->getContent(), User::class, 'json');

        // encode the plain password
        $user->setPassword(
            $userPasswordHasher->hashPassword(
                $user,
                $user->getPassword()
            )
        );
        $entityManager->persist($user);
        $entityManager->flush();
        return $this->json($user, Response::HTTP_CREATED, [], ['groups' => ['user:read']]);
    }
}
