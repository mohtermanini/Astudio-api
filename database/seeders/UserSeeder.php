<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = config('seeds.users');
        foreach ($users as $user) {
            User::create([
                'first_name' => $user['first_name'],
                'last_name' => $user['last_name'],
                'dob' => $user['dob'],
                'gender' => $user['gender'],
                'email' => $user['email'],
                'email_verified_at' => now(),
                'password' => $user['password']
            ]);
        }
    }
}
