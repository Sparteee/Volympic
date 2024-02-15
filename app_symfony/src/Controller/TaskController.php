<?php

namespace App\Controller;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Task;
use App\Entity\User;

class TaskController extends AbstractController
{
    #[Route('/tasks', name: 'app_tasks')]
    public function index(TaskRepository $tr): Response
    {
        $range = "";
        if(isset($_POST['maxRange'])){
            $range = $_POST['maxRange'];
        }

        // recupere toutes les taches
        $tasks = $tr->findAll();
        // Recuperer l'adresse de l'utilisateur connecté
        $user = $this->getUser();
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
        foreach ($tasks as $task){

            $taskLat = $task->getAddress()->getLatitude();
            $taskLong = $task->getAddress()->getLongitude();
            //debug
//            $tasksLong[] = $taskLong;
//            $tasksLat[] = $taskLat;
            $distance = $this->getDistance($addressLat, $addressLong, $taskLat, $taskLong);
            $distances[] = $distance;
            if ($distance < $range){
                // $distances[] = $distance;
                if($task->getEndDate() > new \DateTime('now')){
                    $taskssorted[] = $task;
                }
            } elseif ($range == ""){
                if($task->getEndDate() > new \DateTime('now')){
                    $taskssorted[] = $task;
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
}
