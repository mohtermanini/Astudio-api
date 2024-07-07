<?php

namespace App\Filters\Book;

use App\Interfaces\Filters\PipeLineInterface;
use Closure;

class BookSearchBy implements PipeLineInterface
{
    public function handle(array $content, Closure $next)
    {
        if (isset($content['params']['searchBy'])) {
            $searchBy = $content['params']['searchBy'];
            $content['queryBuilder']->where(
                fn ($query) =>
                $query->where('title', 'like', "%$searchBy%")
                    ->orWhere('description', 'like', "%$searchBy%")
                    ->orWhereHas('category', fn ($categoryQuery) => $categoryQuery->where('name', 'like', "%$searchBy%"))
            );
        }

        return $next($content);
    }
}
