<?php

namespace App\Filters\Timesheet;

use App\Filters\BaseFilters;
use App\Filters\Timesheet\TimesheetSearchBy;
use App\Filters\Timesheet\Date;
use App\Filters\Timesheet\Hours;

class TimesheetFilters extends BaseFilters
{
    public function __construct(public $filters = null)
    {
        $this->filters = $filters ?? [
            Date::class,
            Hours::class,
            TimesheetSearchBy::class,
        ];
    }

    protected function getFilters(): array
    {
        return $this->filters;
    }
}