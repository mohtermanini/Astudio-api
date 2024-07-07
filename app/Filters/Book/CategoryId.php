<?php

namespace App\Filters\Book;

use App\Interfaces\Filters\PipeLineInterface;
use Closure;

class CategoryId implements PipeLineInterface
{
    public function handle(array $content, Closure $next)
    {
        if (isset($content['params']['categoryIds'])) {
            $content['queryBuilder']->whereIn('books.category_id', $content['params']['categoryIds']);
        }

        return $next($content);
    }
}