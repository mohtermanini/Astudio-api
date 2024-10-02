<?php

namespace App\Filters\User;

use Closure;
use Carbon\Carbon;
use App\Interfaces\Filters\PipeLineInterface;

class Dob implements PipeLineInterface
{
    public function handle(array $content, Closure $next)
    {
        if (isset($content['params']['dob'])) {
            $tableName = $content['queryBuilder']->getModel()->getTable();
            $content['queryBuilder']
                ->whereDate("$tableName.dob", $content['params']['dob']);
        }

        return $next($content);
    }
}