<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\ActivityController;

// Register a user
Route::post('/user/register', [AuthController::class, 'register']);

// login user
Route::post('/user/login', [AuthController::class, 'login']);

// other task for logged in User only
Route::group(['middleware' => ['auth:sanctum']], function () {

    // logout the user
    Route::get('/user/logout/{id}', [AuthController::class, 'logout']);

    // get all tasks of requested user
    Route::get('/user/tasks', [TasksController::class, 'show']);

    // add new task
    Route::post('/task/create', [TasksController::class, 'create']);

    // complete or incomplete
    Route::get('/task/complete/{id}', [TasksController::class, 'complete']);

    // favorite or unfavorite
    Route::get('/task/favorite/{id}', [TasksController::class, 'favorite']);

    // delete 
    Route::delete('/task/delete/{id}', [TasksController::class, 'delete']);

    // update task
    Route::post('/task/update/{id}', [TasksController::class, 'update']);


    // activities
    Route::get('/activities', [ActivityController::class, 'list']);
    Route::get('/activities/read', [ActivityController::class, 'read']);
    Route::delete('/activities/delete/{id}', [ActivityController::class, 'delete']);
    
});


