<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function(){

    Route::get('user/{user:username}', [UserController::class, 'show'])->name('user.show');

});

