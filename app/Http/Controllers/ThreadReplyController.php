<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreThreadReplyRequest;
use App\Models\Thread;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class ThreadReplyController extends Controller
{
     /**
      * Display a listing of threads.
      *
      * @param Request $request
      * @param Thread $thread
      * @return Response|ResponseFactory
      * @throws BindingResolutionException
      */
    public function index(Request $request, Thread $thread)
    {
        $threads = $thread->replies()
                            ->withCount('replies')
                            ->with('author')
                            ->latest()
                            ->paginate();

        return response($threads);
    }

     /**
      * Store thread reply
      *
      * @param StoreThreadReplyRequest $request
      * @param Thread $thread
      * @return Response|ResponseFactory
      * @throws ValidationException
      * @throws MassAssignmentException
      * @throws BindingResolutionException
      */
    public function store(StoreThreadReplyRequest $request, Thread $thread)
    {
        // $thread = $thread->replies()->create($request->validated());

        $thread = $request->user()->threads()->create($request->validated() + ["parent_id" => $thread->id]);

        return response($thread, 201);
    }
}
