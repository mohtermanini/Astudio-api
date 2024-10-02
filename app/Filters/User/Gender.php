<?php

namespace App\Filters\User;

use App\Enums\GendersEnum;
use App\Interfaces\Filters\PipeLineInterface;
use Closure;

class Gender implements PipeLineInterface
{
    public function handle(array $content, Closure $next)
    {
        if (isset($content['params']['gender'])) {
            $gender = -1;
            if ($content['params']['gender'] === 'male') {
                $gender = GendersEnum::Male->value;
            } else if ($content['params']['gender'] === 'female') {
                $gender = GendersEnum::FEMALE->value;
            }
            $tableName = $content['queryBuilder']->getModel()->getTable();
            $content['queryBuilder']->where("$tableName.gender", $gender);
        }

        return $next($content);
    }
}