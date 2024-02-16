<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig');
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException(
            'This method can be blank - it will be intercepted by the logout key on your firewall.'
        );
    }

    #[Route(path: '/register', name: 'app_register', methods: ['GET'])]
    public function register(Request $request): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_homepage');
        }
        return $this->render('registration/onboarding.html.twig');
    }

    #[Route(path: '/createUser', name: 'app_createUser', methods: ['POST'])]
    public function createuser(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $em
    ): Response {
        $data = $request->getPayload();
        $user = new User(
            $data->get('email'),
            $data->get('lastname'),
            $data->get('firstname'),
            'default.jpg'
        );
        $user->setPassword(
            $passwordHasher->hashPassword(
                $user,
                $data->get('password')
            )
        );

        $address = new Address(
            $data->get('cityName'),
            (float) $data->get('lat'),
            (float) $data->get('long'),
        );

        $user->setAddress($address);
        $em->persist($address);
        $em->persist($user);
        $em->flush();

        return new JsonResponse(json_encode(['status' => 'created']));
    }
}
