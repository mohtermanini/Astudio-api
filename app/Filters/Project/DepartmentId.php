<?php

namespace App\Filters\Project;

use App\Interfaces\Filters\PipeLineInterface;
use Closure;

class DepartmentId implements PipeLineInterface
{
    public function handle(array $content, Closure $next)
    {
        if (isset($content['params']['departmentIds'])) {
            $tableName = $content['queryBuilder']->getModel()->getTable();
            $content['queryBuilder']->whereIn("$tableName.department_id", $content['params']['departmentIds']);
        }

        return $next($content);
    }
}