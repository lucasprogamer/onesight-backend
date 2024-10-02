<?php

namespace App\Query\Schedule;

use DateTime;

class ListSchedulesQuery
{
    public function __construct(public DateTime|null $date = null) {}
}
