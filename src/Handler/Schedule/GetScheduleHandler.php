<?php

namespace App\Handler\Schedule;

use App\Entity\Schedule;
use App\Query\Schedule\GetScheduleQuery;
use Doctrine\ORM\EntityManagerInterface;

class GetScheduleHandler
{
    public function __construct(private EntityManagerInterface $entityManager) {}

    public function handle(GetScheduleQuery $query): ?Schedule
    {
        return $this->entityManager->getRepository(Schedule::class)->find($query->id);
    }
}