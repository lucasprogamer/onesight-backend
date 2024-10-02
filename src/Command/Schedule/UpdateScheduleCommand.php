<?php

namespace App\Command\Schedule;

class UpdateScheduleCommand
{
    public function __construct(
        public int $id,
        public \DateTimeInterface $datetime,
        public string $event,
        public int $priority
    ) {}
}