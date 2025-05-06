<?php

use App\Http\Controllers\TasksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;



//user register
Route::post('/user/register', [AuthController::class, 'register']);

//user login
Route::post('/user/login', [AuthController::class, 'login']);

//user logout
Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('/user/logout/{id}', [AuthController::class, 'logout']);
    Route::get('user/tasks',[TasksController::class,'show']);
    Route::post('user/tasks/addtask',[TasksController::class,'addtask']);
});






