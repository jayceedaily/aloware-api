<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThreadReplyController;

Route::get('threads/{thread}/replies', [ThreadReplyController::class, 'index'])->name('thread-reply.index');

Route::post('threads/{thread}/replies', [ThreadReplyController::class, 'store'])->name('thread-reply.create');
