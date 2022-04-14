<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Validation\ValidationException;

class PostCommentController extends Controller
{
     /**
      * Show comments for "Post 1"
      *
      * @return Response|ResponseFactory
      * @throws BindingResolutionException
      */
    public function index()
    {
        $comments = Comment::whereNull('parent_id')
                            ->withCount('replies')
                            ->latest()
                            ->paginate();

        return response($comments);
    }

     /**
      * Store a comment
      *
      * @param StoreCommentRequest $request
      * @return Response|ResponseFactory
      * @throws ValidationException
      * @throws BindingResolutionException
      */
    public function store(StoreCommentRequest $request)
    {
        $comment = Comment::create($request->validated());

        return response($comment, 201);
    }
}
