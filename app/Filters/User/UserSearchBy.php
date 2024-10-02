<?php

namespace App\Filters\User;

use App\Interfaces\Filters\PipeLineInterface;
use Closure;

class UserSearchBy implements PipeLineInterface
{
    public function handle(array $content, Closure $next)
    {
        if (isset($content['params']['searchBy'])) {
            $searchBy = $content['params']['searchBy'];
            $content['queryBuilder']->where(
                fn($query) =>
                $query->where('first_name', 'like', "%$searchBy%")
                    ->orWhere('last_name', 'like', "%$searchBy%")
                    ->orWhere('email', 'like', "%$searchBy%")
            );
        }

        return $next($content);
    }
}
