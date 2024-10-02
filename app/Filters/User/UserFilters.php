<?php

namespace App\Filters\User;

use App\Filters\BaseFilters;

class UserFilters extends BaseFilters
{
    public function __construct(public $filters = null)
    {
        $this->filters = $filters ?? [
            Dob::class,
            Gender::class,
            UserSearchBy::class,
        ];
    }

    protected function getFilters(): array
    {
        return $this->filters;
    }
}