<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserFollowerController;

Route::middleware('auth:sanctum')->group(function(){

    Route::get('user/{user}/followers', [UserFollowerController::class, 'index'])->name('user.followers.index');
});
