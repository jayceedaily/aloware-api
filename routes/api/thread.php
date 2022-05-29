<?php

use App\Http\Controllers\ThreadController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function(){

    Route::get('threads', [ThreadController::class, 'index'])->name('thread.index');

    Route::get('thread/{thread}', [ThreadController::class, 'show'])->name('thread.show');

    Route::post('thread', [ThreadController::class, 'store'])->name('thread.create');
});

