<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentReplyController;

Route::get('comments/{comment}/replies', [CommentReplyController::class, 'index']);

Route::post('comments/{comment}/replies', [CommentReplyController::class, 'store']);
