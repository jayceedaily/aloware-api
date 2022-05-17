<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Http\Requests\StoreThreadRequest;
use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Validation\ValidationException;

class PostThreadController extends Controller
{
     /**
      * Show threads for "Post 1"
      *
      * @return Response|ResponseFactory
      * @throws BindingResolutionException
      */
    public function index()
    {
        $threads = Thread::whereNull('parent_id')
                            ->withCount('replies')
                            ->with('author')
                            ->latest()
                            ->paginate();

        return response($threads);
    }

     /**
      * Store a thread
      *
      * @param StoreThreadRequest $request
      * @return Response|ResponseFactory
      * @throws ValidationException
      * @throws BindingResolutionException
      */
    public function store(StoreThreadRequest $request)
    {
        // @TODO refactor created_by as Model event
        $thread = $request->user()->threads()->create($request->validated());

        return response($thread, 201);
    }
}
