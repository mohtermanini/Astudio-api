<?php

namespace App\Filters\Timesheet;

use App\Interfaces\Filters\PipeLineInterface;
use Closure;

class TimesheetSearchBy implements PipeLineInterface
{
    public function handle(array $content, Closure $next)
    {
        if (isset($content['params']['searchBy'])) {
            $searchBy = $content['params']['searchBy'];
            $content['queryBuilder']->where(
                fn($query) =>
                $query->where('task_name', 'like', "%$searchBy%")
            );
        }

        return $next($content);
    }
}
