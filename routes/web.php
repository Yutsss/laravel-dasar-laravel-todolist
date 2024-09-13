<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'home']);

Route::get('/template', function () {
    return view('template');
});

Route::controller(\App\Http\Controllers\UserController::class)->group(function () {
    Route::get('/login', 'login')->middleware('onlyGuest');
    Route::post('/login', 'doLogin')->middleware('onlyGuest');
    Route::post('/logout', 'doLogout')->middleware('onlyMember');
});

Route::controller(\App\Http\Controllers\TodolistController::class)
    ->middleware('onlyMember')
    ->group(function () {
        Route::get('/todolist', 'todoList');
        Route::post('/todolist', 'addTodo');
        Route::post('/todolist/{id}/delete', 'removeTodo');
    });
