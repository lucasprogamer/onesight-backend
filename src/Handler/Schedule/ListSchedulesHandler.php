<?php

namespace App\Handler\Schedule;

use App\Entity\Schedule;
use App\Query\Schedule\ListSchedulesQuery;
use Doctrine\ORM\EntityManagerInterface;

class ListSchedulesHandler
{
    public function __construct(private EntityManagerInterface $entityManager) {}

    public function handle(ListSchedulesQuery $query): array
    {
        return $this->entityManager->getRepository(Schedule::class)->findAll();
    }
}