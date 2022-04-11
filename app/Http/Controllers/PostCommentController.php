<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;

class PostCommentController extends Controller
{
    /**
     * Show comments for "Post 1"
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::whereNull('parent_id')
                            ->withCount('children')
                            ->with('latestChild')
                            ->latest()
                            ->paginate();

        return response($comments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCommentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCommentRequest $request)
    {
        $comment = Comment::create($request->validated());

        return response($comment, 201);
    }
}
