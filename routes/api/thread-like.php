<?php

use App\Http\Controllers\ThreadLikeController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function(){

    Route::post('thread/{thread}/like', [ThreadLikeController::class, 'store'])->name('thread-like.create');

    Route::delete('thread/{thread}/unlike', [ThreadLikeController::class, 'destroy'])->name('thread-like.delete');
});
