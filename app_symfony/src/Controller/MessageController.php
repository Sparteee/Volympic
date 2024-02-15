<?php

namespace App\Controller;

use App\Entity\Conversation;
use App\Entity\Message;
use App\Entity\User;
use App\Repository\MessageRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

class MessageController extends AbstractController
{
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[Route('/messages', name: 'app_messages_index')]
    public function index(MessageRepository $message_repository): Response
    {
        $messages = $message_repository->findAll();

        return $this->render('message/index.html.twig', [
            'messages' => $messages,
        ]);
    }

    // TODO: handle conversation ID
    #[Route('/messages/send', name: 'app_messages_send', methods: ['POST'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function send(
        #[CurrentUser] User $user,
        HubInterface $hub,
        Request $request,
        SerializerInterface $serializer,
        EntityManagerInterface $entity_manager
    ): JsonResponse {
        // TODO: get conversation dynamically
        $conversation = $entity_manager
            ->getRepository(Conversation::class)
            ->findOneBy(['id' => 3]);

        $data = $request->getPayload();

        $content = $data->get('content');

        $message = new Message($content, new DateTime());
        $message->setUser($user);
        $message->setConversation($conversation);

        $entity_manager->persist($message);
        $entity_manager->flush();

        $json = $serializer->serialize($message, 'json', ['groups' => 'messages']);

        $update = new Update('http://koolkids.com/messages/1', $json);

        $hub->publish($update);

        return new JsonResponse(json_encode(['status' => 'published!']));
    }


    #[Route('/conversation' , name: 'app_conversation')]
    public function conversation(): Response
    {
        return $this->render('conversation/index.html.twig', [
        ]);
    }
}
