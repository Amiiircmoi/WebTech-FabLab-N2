<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/b-y!M&e/login/b-y!B&o', name: 'app_login')]
    public function index(AuthenticationUtils $authenticationUtils, ): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    #[Route('/logout', name: 'app_logout', methods: ['GET'])]
    public function logout() {}

    // #[Route('/register', name: 'app_register')]
    // public function register(UserPasswordHasherInterface $passwordHasher, UserRepository $userRepository)
    // {
    //     $user = new User();
    //     $user->setUsername('amir')
    //         ->setRoles(['ROLE_ADMIN'])
    //         ->setPassword($passwordHasher->hashPassword($user, 'leswebtechsontbeaux'))
    //     ;
    //     $userRepository->save($user, true);
    //     dd($user);

    // }
}