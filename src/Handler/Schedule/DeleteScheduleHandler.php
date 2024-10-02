<?php

namespace App\Handler\Schedule;

use App\Command\DeleteScheduleCommand;
use App\Entity\Schedule;
use Doctrine\ORM\EntityManagerInterface;

class DeleteScheduleHandler
{
    public function __construct(private EntityManagerInterface $entityManager) {}

    public function handle(DeleteScheduleCommand $command): void
    {
        $schedule = $this->entityManager->getRepository(Schedule::class)->find($command->id);

        if ($schedule) {
            $this->entityManager->remove($schedule);
            $this->entityManager->flush();
        }
    }
}