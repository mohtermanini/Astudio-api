<?php

namespace App\Filters\Timesheet;

use Closure;
use Carbon\Carbon;
use App\Interfaces\Filters\PipeLineInterface;

class Date implements PipeLineInterface
{
    public function handle(array $content, Closure $next)
    {
        if (isset($content['params']['date'])) {
            $tableName = $content['queryBuilder']->getModel()->getTable();
            $content['queryBuilder']
                ->whereDate("$tableName.date", '=', $content['params']['date']);
        }

        return $next($content);
    }
}