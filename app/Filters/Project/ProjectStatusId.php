<?php

namespace App\Filters\Project;

use App\Interfaces\Filters\PipeLineInterface;
use Closure;

class ProjectStatusId implements PipeLineInterface
{
    public function handle(array $content, Closure $next)
    {
        if (isset($content['params']['statusIds'])) {
            $tableName = $content['queryBuilder']->getModel()->getTable();
            $content['queryBuilder']->whereIn("$tableName.status_id", $content['params']['statusIds']);
        }

        return $next($content);
    }
}