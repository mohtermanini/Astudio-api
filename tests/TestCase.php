<?php

namespace Tests;

use App\Enums\RolesEnum;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    //execute DatabaseSeeder class before each test that uses the RefreshDatabase trait
    protected $seed = true;

    protected function createRandomUser($email = null)
    {
        $user = User::factory()
            ->state(function () use ($email) {
                return $email !== null ? ['email' => $email] : [];
            })
            ->create();

        return $user;
    }
}
