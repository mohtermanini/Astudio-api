<?php

namespace App\Filters\Project;

use Closure;
use Carbon\Carbon;
use App\Interfaces\Filters\PipeLineInterface;

class DateRange implements PipeLineInterface
{
    public function handle(array $content, Closure $next)
    {
        if (isset($content['params']['startDate']) && isset($content['params']['endDate'])) {
            $tableName = $content['queryBuilder']->getModel()->getTable();
            $content['queryBuilder']
                ->whereDate("$tableName.start_date", '>=', $content['params']['startDate'])
                ->whereDate("$tableName.end_date", '<', Carbon::parse($content['params']['endDate'])->addDay()->toDateString());
        }

        return $next($content);
    }
}