<?php

use App\Http\Controllers\UserFollowingController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function(){

    Route::get('user/{user}/following', [UserFollowingController::class, 'index'])->name('user-following.index');

    Route::post('user/{user}/follow', [UserFollowingController::class, 'store'])->name('user-following.create');

    Route::delete('user/{user}/unfollow', [UserFollowingController::class, 'delete'])->name('user-following.delete');
});

