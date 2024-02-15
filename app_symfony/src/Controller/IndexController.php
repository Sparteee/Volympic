<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('default/index.html.twig', [
        ]);
    }


    #[Route('/dev', name: 'app_dev')]
    public function dev(): Response
    {
        return $this->render('default/dev.html.twig', [
        ]);
    }

    #[Route('/home', name: 'app_homepage')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function homepage(): Response
    {
        $currentUser = $this->getUser();
        $taskCount = count($currentUser->getTasks());

        return $this->render('homepage/homepage.html.twig', [
            'user' => $currentUser,
            'taskCount' => $taskCount,
        ]);
    }

    #[Route('/planning', name: 'app_planning')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function planning(): Response
    {
        $currentUser = $this->getUser();
        $tasks = $currentUser->getTasks();
        $arrayTaskToday = [];
        $arrayTaskPast = [];
        $arrayTaskFutur = [];
        $today = new \DateTime("2024-08-01"); /* NOW */


        foreach ($tasks as $task) {
            $taskDateDebut = $task->getStartDate();
            $taskEndDate = $task->getEndDate();

            if ((strtotime($today->format('Y-m-d')) >= strtotime($taskDateDebut->format('Y-m-d')) &&
                strtotime($today->format('Y-m-d')) <= strtotime($taskEndDate->format('Y-m-d'))))
            {
                $arrayTaskToday[] = $task;
            }
            if (strtotime($today->format('Y-m-d')) > strtotime($taskEndDate->format('Y-m-d'))) {
                $arrayTaskPast[] = $task;
            }

            if (strtotime($today->format('Y-m-d')) < strtotime($taskDateDebut->format('Y-m-d'))) {

                $arrayTaskFutur[] = $task;
            }
        }

        return $this->render('homepage/planning.html.twig', [
            'user' => $currentUser,
            'arrayTaskToday' => $arrayTaskToday,
            'arrayTaskPast' => $arrayTaskPast,
            'arrayTaskFutur' => $arrayTaskFutur,
            'today' => $today,
            'tasks' => $tasks
        ]);
    }
}
