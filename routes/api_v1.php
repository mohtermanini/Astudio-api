<?php

use App\Http\Controllers\Api\V1\ProjectController;
use App\Http\Controllers\Api\V1\TimesheetController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;

Route::controller(AuthController::class)
    ->prefix('auth')
    ->name('auth.')
    ->group(function () {
        Route::get('/', 'show')->name('show')->middleware('auth:sanctum');
        Route::post('/', 'store')->name('store');
        Route::delete('/', 'destroy')->name('destroy')->middleware('auth:sanctum');
    });

Route::controller(ProjectController::class)
    ->prefix("projects")
    ->name("projects.")
    ->middleware(["auth:sanctum"])
    ->group(function () {
        Route::get("/", "index")->name("index");
        Route::get("/{id}", "show")->name("show");
        Route::post("/", "store")->name("store");
        Route::put("/{id}", "update")->name("update");
        Route::delete("/{id}", "destroy")->name("destroy");
    });

Route::controller(UserController::class)
    ->prefix("users")
    ->name("users.")
    ->middleware(["auth:sanctum"])
    ->group(function () {
        Route::get("/", "index")->name("index");
        Route::get("/{id}", "show")->name("show");
        Route::post("/", "store")->name("store");
        Route::put("/{id}", "update")->name("update");
        Route::delete("/{id}", "destroy")->name("destroy");
    });

Route::controller(TimesheetController::class)
    ->prefix("timesheet")
    ->name("timesheet.")
    ->middleware(["auth:sanctum"])
    ->group(function () {
        Route::get("/", "index")->name("index");
        Route::get("/{id}", "show")->name("show");
        Route::post("/", "store")->name("store");
        Route::put("/{id}", "update")->name("update");
        Route::delete("/{id}", "destroy")->name("destroy");
    });
