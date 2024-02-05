<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[isGranted("ROLE_USER")]
class JoController extends AbstractController
{
    #[Route('/jo', name: 'app_jo')]
    public function index(): Response
    {
        return $this->render('jo/index.html.twig', [
            'JO' => 'Paris 2024'
        ]);
    }
}
