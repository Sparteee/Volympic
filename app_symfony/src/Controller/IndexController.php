<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{

    #[Route('/dev', name: 'app_dev')]
    public function dev(): Response
    {
        return $this->render('default/dev.html.twig', [
        ]);
    }
}
