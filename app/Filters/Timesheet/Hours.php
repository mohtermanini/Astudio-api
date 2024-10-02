<?php

namespace App\Filters\Timesheet;

use App\Interfaces\Filters\PipeLineInterface;
use Closure;

class Hours implements PipeLineInterface
{
    public function handle(array $content, Closure $next)
    {
        if (isset($content['params']['maxHours'])) {
            $tableName = $content['queryBuilder']->getModel()->getTable();
            $content['queryBuilder']->where("$tableName.hours", '<=', $content['params']['maxHours']);
        }

        return $next($content);
    }
}