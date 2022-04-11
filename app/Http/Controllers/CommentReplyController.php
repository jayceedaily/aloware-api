<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentReplyRequest;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Comment $comment)
    {
        $comments = $comment
                            ->children()
                            ->withCount('children')
                            ->with('latestChild')
                            ->latest()
                            ->paginate();

        return response($comments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCommentReplyRequest $request, Comment $comment)
    {
        $comment = $comment->children()->create($request->validated());

        return response($comment, 201);
    }
}
