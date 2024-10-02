<?php

namespace App\Command\Schedule;

class CreateScheduleCommand
{
    public function __construct(
        public \DateTimeInterface $datetime,
        public string $event,
        public int $priority
    ) {}
}