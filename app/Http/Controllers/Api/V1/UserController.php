<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use App\Services\UserService;

class UserController extends Controller
{
    public function index(UserService $userService)
    {
        $users = $userService->getUsers(
            filters: request()->all(),
            pageSize: request()->pageSize ?? config('meta.pagination.page_size')
        );

        return new UserCollection($users);
    }

    public function show(UserService $userService, $id)
    {
        try {
            $user = $userService->getUser($id);
        } catch (\Exception $e) {
            abort($e->getCode(), $e->getMessage());
        }

        return new UserResource($user);
    }

    public function store(StoreUserRequest $storeUserRequest, UserService $userService)
    {
        try {
            $user = $userService->createFromRequest($storeUserRequest);
        } catch (\Exception $e) {
            abort($e->getCode(), $e->getMessage());
        }

        return $this->responseCreated(new UserResource($user));
    }

    public function update(UpdateUserRequest $updateUserRequest, UserService $userService, $id)
    {
        try {
            $user = $userService->updateFromRequest($updateUserRequest, $id);
        } catch (\Exception $e) {
            dd($e);
            abort($e->getCode(), $e->getMessage());
        }

        return $this->responseOk(new UserResource($user));
    }

    public function destroy(UserService $userService, $id)
    {
        try {
            $userService->delete($id);
        } catch (\Exception $e) {
            dd($e);
            abort($e->getCode(), $e->getMessage());
        }

        return $this->responseDeleted();
    }
}
