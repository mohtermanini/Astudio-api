<?php

namespace App\Services;

use App\Enums\GendersEnum;
use App\Filters\User\UserFilters;
use App\Models\User;
use DB;

class UserService
{
    public function getUsers($filters, $pageSize = null)
    {
        $queryBuilder = User::select('*');

        $filteredUsers = app(UserFilters::class)->filter([
            'queryBuilder' => $queryBuilder,
            'params' => $filters
        ]);

        $users = $filteredUsers->when($pageSize, fn($query) => $query->paginate($pageSize), fn($query) => $query->get());

        return $users;
    }

    public function getUser($id)
    {
        $user = User::find($id);
        if (!$user) {
            throw new \Exception('User Not Found.', 404);
        }

        return $user;
    }

    public function getUserByEmail($email = null)
    {
        $user = User::where('email', $email)->first();

        return $user;
    }

    public function createFromRequest($request)
    {
        $user = null;

        DB::transaction(function () use ($request, &$user) {
            $user = User::create([
                'first_name' => $request->firstName,
                'last_name' => $request->lastName,
                'dob' => $request->dob,
                'gender' => $request->gender === 'male' ? GendersEnum::Male : GendersEnum::FEMALE,
                'email' => $request->email,
                'password' => $request->password,
            ]);
        });

        if (is_null($user)) {
            throw new \Exception('Failed to create the user.');
        }

        return $user;
    }

    public function updateFromRequest($request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            throw new \Exception('User not found.', 422);
        }

        DB::transaction(function () use ($request, $user) {
            $user->update(
                [
                    'first_name' => $request->firstName,
                    'last_name' => $request->lastName,
                    'dob' => $request->dob,
                    'gender' => $request->gender === 'male' ? GendersEnum::Male : GendersEnum::FEMALE,
                    'email' => $request->email,
                ]
                + ($request->password ? ['password' => $request->password] : [])
            );
        });

        return $user->refresh();
    }

    public function delete($id)
    {
        $user = User::find($id);

        if (!$user) {
            throw new \Exception('User not found.', 422);
        }

        DB::transaction(function () use ($user) {
            $user->projects()->detach();
            $user->timesheets()->delete();
            $user->tokens()->delete();
            $user->delete();
        });
    }
}
