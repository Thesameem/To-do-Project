<?php

use App\Http\Controllers\ActivityController;
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

    //list all task
    Route::get('user/tasks',[TasksController::class,'show']);

    //add new task
    Route::post('tasks/create',[TasksController::class,'create']);

    //complete or incomplete
    Route::get('tasks/complete/{id}',[TasksController::class,'complete']);
    //favourite or unfavourite
    Route::get('tasks/favourite/{id}',[TasksController::class,'favourite']);

    //delete
    Route::delete('tasks/delete/{id}',[TasksController::class,'delete']);

    //update task
    Route::post('tasks/update/{id}',[TasksController::class,'updatetask']);

    //list all activities
    Route::get('/activities',[ActivityController::class,'list']);

    //mark as read activities
    Route::post('/activities/read/{id}',[ActivityController::class,'read']);
    //delete acitivties
    Route::delete('/activities/delete/{id}',[ActivityController::class,'delete']);




    
});






