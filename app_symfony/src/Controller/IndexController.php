<?php

namespace App\Controller;

use Random\RandomException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class IndexController extends AbstractController
{
    #[Route('/home', name: 'app_homepage')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function homepage(): Response
    {
        $currentUser = $this->getUser();
        $taskCount = count($currentUser->getTasks());
        $task = $currentUser->getTasks()[0];

        return $this->render('homepage/homepage.html.twig', [
            'user' => $currentUser,
            'taskCount' => $taskCount,
            'task' => $task
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

    /**
     * @throws RandomException
     */
    #[Route('/random', name: 'app_random')]
    public function random(): Response
    {

        return $this->render('homepage/random.html.twig', [
            'random' => random_int(0, 50)
        ]);
    }
}
