<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class MessageController extends AbstractController
{
    #[Route('/messages', name: 'app_messages_index')]
    public function index(): Response
    {
        return $this->render('message/index.html.twig', [
            'controller_name' => 'MessageController',
        ]);
    }

    #[Route('/messages/send', name: 'app_messages_send', methods: ['POST'])]
    public function send(HubInterface $hub, Request $request, SerializerInterface $serializer): JsonResponse
    {
        $user = $serializer->serialize($this->getUser(), 'json');


        $data = $request->getPayload();

        $content = $data->get('content');

        $message = new Message();
        $message->setContent($content);
        $message->setTimestamp(new \DateTime());

        $json = $serializer->serialize($message, 'json');

        $update = new Update(
            'http://koolkids.com/messages/1',
            json_encode(['message' => $json, 'user' => $user])
        );

        $hub->publish($update);

        return new JsonResponse(json_encode(['status' => 'published!']));
    }
}
