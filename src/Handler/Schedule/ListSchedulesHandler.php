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
        // Verifique se a data é nula
        if ($query->date === null) {
            return [];
        }

        // Formatar a data
        $date = $query->date->format('Y-m-d');

        return $this->entityManager->createQueryBuilder()
            ->select('s')
            ->from(Schedule::class, 's')
            ->where('s.datetime LIKE :date')
            ->setParameter('date', $date . '%') // Adiciona um wildcard para capturar qualquer hora
            ->orderBy('s.priority', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
