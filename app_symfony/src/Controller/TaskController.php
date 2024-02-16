<?php

namespace App\Controller;

use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Task;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class TaskController extends AbstractController
{
    #[Route('/tasks', name: 'app_tasks')]
    public function index(#[CurrentUser] User $user, TaskRepository $tr,EntityManagerInterface $em): Response
    {
        $range = "";
        if (isset($_POST['maxRange'])) {
            $range = $_POST['maxRange'];
        }

        // recupere toutes les taches
        $tasks = $tr->findAll();
        // Recuperer l'adresse de l'utilisateur connecté
        $address = $user->getAddress();
        $addressLat = $address->getLatitude();
        $addressLong = $address->getLongitude();
        // On crée un tableau vide pour stocker les taches triées
        $taskssorted = [];
        //debug
//        $distances = [];
//        $tasksLong = [];
//        $tasksLat = [];
        $distances = [];
        foreach ($tasks as $task) {
            if (isset($_POST['participer'])) {
                $task_id= $_POST['task_id'];
                $task = $tr->find($task_id);
                $task->addUser($user);
                $em->persist($task);

                $user->addConversation($task->getConversation());
                $em->persist($user);
                $em->flush();
            }
            $taskLat = $task->getAddress()->getLatitude();
            $taskLong = $task->getAddress()->getLongitude();
            //debug
//            $tasksLong[] = $taskLong;
//            $tasksLat[] = $taskLat;
            $distance = $this->getDistance($addressLat, $addressLong, $taskLat, $taskLong);
            $distances[] = $distance;
            if (!$task->getUsers()->contains($user)) {
                if ($distance < $range) {
                    // $distances[] = $distance;
                    if ($task->getEndDate() > new \DateTime('now')) {
                        $taskssorted[] = $task;
                    }
                } elseif ($range == "") {
                    if ($task->getEndDate() > new \DateTime('now')) {
                        $taskssorted[] = $task;
                    }
                }
            }


        }
        return $this->render('tasks/index.html.twig', [
            "address" => $address,
            'tasks' => $taskssorted,
            /* 'distances' => $distances, //debug
             "addresslat" => $addressLat,
             "addresslong" => $addressLong,
             "tasksLat" => $tasksLat,
             "tasksLong" => $tasksLong*/
        ]);
    }

    public function getDistance($addressLat, $addressLong, $taskLat, $taskLong): float|int
    {
        $earthRadius = 6371;
        $latFrom = deg2rad($addressLat);
        $lonFrom = deg2rad($addressLong);
        $latTo = deg2rad($taskLat);
        $lonTo = deg2rad($taskLong);
        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;
        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
                cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        return $angle * $earthRadius;
    }

    #[Route("/tasks/{id}/map", name: "app_map")]
    public function map($id, TaskRepository $tr): Response
    {
        $task = $tr->find($id);
        $address = $task->getAddress();
        $addressLat = $address->getLatitude();
        $addressLong = $address->getLongitude();
        return $this->render('tasks/map.html.twig', [
            "address" => $address,
            "addresslat" => $addressLat,
            "addresslong" => $addressLong,
        ]);
    }
}
