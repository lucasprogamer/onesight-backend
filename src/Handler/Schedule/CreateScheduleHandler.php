<?php

namespace App\Handler\Schedule;

use App\Command\Schedule\CreateScheduleCommand;
use App\Entity\Schedule;
use Doctrine\ORM\EntityManagerInterface;

class CreateScheduleHandler
{
    public function __construct(private EntityManagerInterface $entityManager) {}

    public function handle(CreateScheduleCommand $command): Schedule
    {
        $schedule = new Schedule();
        $schedule->setDatetime($command->datetime);
        $schedule->setEvent($command->event);
        $schedule->setPriority($command->priority);

        $this->entityManager->persist($schedule);
        $this->entityManager->flush();

        return $schedule;
    }
}