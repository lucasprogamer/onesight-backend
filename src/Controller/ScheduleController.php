<?php

namespace App\Controller;

use App\Command\DeleteScheduleCommand;
use App\Command\Schedule\CreateScheduleCommand;
use App\Command\Schedule\UpdateScheduleCommand;
use App\Handler\Schedule\CreateScheduleHandler;
use App\Handler\Schedule\DeleteScheduleHandler;
use App\Handler\Schedule\GetScheduleHandler;
use App\Handler\Schedule\ListSchedulesHandler;
use App\Handler\Schedule\UpdateScheduleHandler;
use App\Query\Schedule\GetScheduleQuery;
use App\Query\Schedule\ListSchedulesQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ScheduleController extends AbstractController
{
    #[Route('/schedules', methods: ['GET'])]
    public function list(Request $request, ListSchedulesHandler $handler): JsonResponse
    {

        $dateParam = $request->query->get('date');

        $query = new ListSchedulesQuery();
        if ($dateParam) {
            $query->date = new \DateTime($dateParam);
        }

        $list = $handler->handle($query);

        $schedules = array_map(function ($schedule) {
            return $schedule->toArray();
        }, $list);

        return $this->json($schedules);
    }

    #[Route('/schedules/{id}', methods: ['GET'])]
    public function get(int $id, GetScheduleHandler $handler): JsonResponse
    {
        $schedule = $handler->handle(new GetScheduleQuery($id));
        if (!$schedule) {
            return $this->json(['message' => 'Schedule not found'], 404);
        }

        return $this->json($schedule->toArray());
    }

    #[Route('/schedules', methods: ['POST'])]
    public function create(Request $request, CreateScheduleHandler $handler): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $command = new CreateScheduleCommand(
            new \DateTime($data['datetime']),
            $data['event'],
            $data['priority']
        );
        $schedule = $handler->handle($command);

        return $this->json($schedule->toArray(), 201);
    }

    #[Route('/schedules/{id}', methods: ['PUT'])]
    public function update(int $id, Request $request, UpdateScheduleHandler $handler): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $command = new UpdateScheduleCommand(
            $id,
            new \DateTime($data['datetime']),
            $data['event'],
            $data['priority']
        );
        $schedule = $handler->handle($command);

        if (!$schedule) {
            return $this->json(['message' => 'Schedule not found'], 404);
        }

        return $this->json($schedule->toArray());
    }

    #[Route('/schedules/{id}', methods: ['DELETE'])]
    public function delete(int $id, DeleteScheduleHandler $handler): JsonResponse
    {
        $handler->handle(new DeleteScheduleCommand($id));

        return $this->json(null, 204);
    }
}
