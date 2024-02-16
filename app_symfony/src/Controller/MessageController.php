<?php

namespace App\Controller;

use App\Entity\Conversation;
use App\Entity\Message;
use App\Entity\User;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
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
    #[Route('/conversations', name: 'app_conversation')]
    public function conversation(#[CurrentUser] User $user): Response
    {
        $conversations = $user->getConversations();

        // TODO: handle no conversation for current user
        return $this->render('conversation/index.html.twig', [
            'conversations' => $conversations
        ]);
    }

    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[Route('/conversations/{conv_id}', name: 'app_conversation_single')]
    public function index(
        #[CurrentUser] User $user,
        #[MapEntity(id: 'conv_id')] Conversation $conversation,
    ): Response {
        // bounce user that don't belong to the conversation
        if ( ! $conversation->getUsers()->contains($user)) {
            return $this->redirectToRoute('app_conversation');
        }

        $messages = $conversation->getMessages();

        return $this->render('conversation/chat.html.twig', [
            'messages'       => $messages,
            'user'           => $user,
            'conversationId' => $conversation->getId(),
        ]);
    }

    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[Route('/conversations/{conv_id}/send', name: 'app_conversation_send', methods: ['POST'])]
    public function send(
        #[CurrentUser] User $user,
        #[MapEntity(id: 'conv_id')] Conversation $conversation,
        HubInterface $hub,
        Request $request,
        SerializerInterface $serializer,
        EntityManagerInterface $entity_manager
    ): JsonResponse {
        $data    = $request->getPayload();
        $content = $data->get('content');

        $message = new Message($content, new DateTime());
        $message->setUser($user);
        $message->setConversation($conversation);

        $entity_manager->persist($message);
        $entity_manager->flush();

        $json = $serializer->serialize($message, 'json', ['groups' => 'messages']);

        $update = new Update('http://koolkids.com/conversation/'.$conversation->getId(), $json);

        $hub->publish($update);

        return new JsonResponse(json_encode(['status' => 'published!']));
    }
}
