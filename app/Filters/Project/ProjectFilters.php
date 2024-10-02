<?php

namespace App\Filters\Project;

use App\Filters\BaseFilters;
use App\Filters\Project\DepartmentId;
use App\Filters\Project\ProjectStatusId;
use App\Filters\Project\ProjectSearchBy;

class ProjectFilters extends BaseFilters
{
    public function __construct(public $filters = null)
    {
        $this->filters = $filters ?? [
            DepartmentId::class,
            DateRange::class,
            ProjectStatusId::class,
            ProjectSearchBy::class,
        ];
    }

    protected function getFilters(): array
    {
        return $this->filters;
    }
}