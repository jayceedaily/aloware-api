<?php

use App\Http\Controllers\PostThreadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('posts/1/threads', [PostThreadController::class, 'index'])->name('post-thread.index');

Route::post('posts/1/threads', [PostThreadController::class, 'store'])->name('post-thread.create');
