<?php

use App\Http\Controllers\{BoardController, HomeController, TaskController};

Auth::routes();

Route::any('/', HomeController::class)->name('home');

Route::apiResources([
    'boards' => BoardController::class,
    'tasks' => TaskController::class
], ['except' => ['show']]);
