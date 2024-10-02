<?php

namespace App\Handler\Schedule;

use App\Command\Schedule\UpdateScheduleCommand;
use App\Entity\Schedule;
use Doctrine\ORM\EntityManagerInterface;

class UpdateScheduleHandler
{
    public function __construct(private EntityManagerInterface $entityManager) {}

    public function handle(UpdateScheduleCommand $command): ?Schedule
    {
        $schedule = $this->entityManager->getRepository(Schedule::class)->find($command->id);

        if (!$schedule) {
            return null;
        }

        $schedule->setDatetime($command->datetime);
        $schedule->setEvent($command->event);
        $schedule->setPriority($command->priority);

        $this->entityManager->flush();

        return $schedule;
    }
}