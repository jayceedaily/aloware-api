<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentReplyRequest;
use App\Models\Comment;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class CommentReplyController extends Controller
{
     /**
      * Display a listing of comments.
      *
      * @param Request $request
      * @param Comment $comment
      * @return Response|ResponseFactory
      * @throws BindingResolutionException
      */
    public function index(Request $request, Comment $comment)
    {
        $comments = $comment
                            ->replies()
                            ->withCount('replies')
                            ->latest()
                            ->paginate();

        return response($comments);
    }

     /**
      * Store comment reply
      *
      * @param StoreCommentReplyRequest $request
      * @param Comment $comment
      * @return Response|ResponseFactory
      * @throws ValidationException
      * @throws MassAssignmentException
      * @throws BindingResolutionException
      */
    public function store(StoreCommentReplyRequest $request, Comment $comment)
    {
        $comment = $comment->replies()->create($request->validated());

        return response($comment, 201);
    }
}
