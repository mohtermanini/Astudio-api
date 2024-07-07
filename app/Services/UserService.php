<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function getUser($id = null, $email = null)
    {
        $user = User::with(['profile', 'role'])
            ->when($id, fn ($query) => $query->where('id', $id))
            ->when($email, fn ($query) => $query->where('email', $email))
            ->first();

        return $user;
    }
}
