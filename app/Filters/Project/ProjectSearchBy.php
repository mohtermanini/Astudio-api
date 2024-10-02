<?php

namespace App\Filters\Project;

use App\Interfaces\Filters\PipeLineInterface;
use Closure;

class ProjectSearchBy implements PipeLineInterface
{
    public function handle(array $content, Closure $next)
    {
        if (isset($content['params']['searchBy'])) {
            $searchBy = $content['params']['searchBy'];
            $content['queryBuilder']->where(
                fn($query) =>
                $query->where('name', 'like', "%$searchBy%")
            );
        }

        return $next($content);
    }
}
