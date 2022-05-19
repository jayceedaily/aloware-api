<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThreadReplyController;

Route::middleware('auth:sanctum')->group(function(){

    Route::get('thread/{thread}/replies', [ThreadReplyController::class, 'index'])->name('thread-reply.index');

    Route::post('thread/{thread}/reply', [ThreadReplyController::class, 'store'])->name('thread-reply.create');

});
