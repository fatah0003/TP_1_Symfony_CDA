<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ApiEventController extends AbstractController
{
    private array $events = [
        [
            'id' => 1,
            'title' => 'Symfony',
            'location' => 'Lyon',
            'date' => '2025-06-10',
            'isPublic' => true,
        ],
        [
            'id' => 2,
            'title' => 'JavaScript',
            'location' => 'Nantes',
            'date' => '2025-09-15',
            'isPublic' => false,
        ],
    ];
    #[Route('/api/event', name: 'app_api_event', methods: ['GET'])]
    public function index(): Response
    {
        return $this->json($this->events);
    }
    #[Route('/api/events/public', name: 'app_api_event_public', methods: ['GET'])]
    public function showPublic(): Response
    {
        $publicEvents = [];

        foreach ($this->events as $event) {
            if ($event['isPublic']) {
                $publicEvents[] = $event;
            }
        }

        return $this->json($publicEvents);
    }
#[Route('/api/events/{id}', name: 'app_api_event_id', methods: ['GET'])]
    public function getEvent(int $id): Response{
        return $this->json($this->events[$id-1]);
    }

    #[Route('', name: 'add_event', methods: ['POST'])]
    public function add(Request $request): JsonResponse{
        $data = json_decode($request -> getContent(), true);
        $data['id'] = rand(100,900);

        return new JsonResponse(
            ['message' => 'evenement ajouté',
                'evenement' => $data],
            Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'delete_event', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse{
        return new JsonResponse([
            'message' => "evenement $id supprimé"
        ], Response::HTTP_NO_CONTENT);
    }
    #[Route('/{id}', name: 'update_evenement', methods: ['PUT'])]
    public function update(Request $request, int $id): JsonResponse{
        $data = json_decode($request -> getContent(), true);
        $data['id'] = $id;
        return new JsonResponse([
            'message' => "evenement $id mis à jour",
            'evenement' => $data
        ], Response::HTTP_OK);
    }
}

