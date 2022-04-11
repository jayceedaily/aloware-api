<?php

use App\Http\Controllers\PostCommentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('posts/1/comments', [PostCommentController::class, 'index']);

Route::post('posts/1/comments', [PostCommentController::class, 'store']);
