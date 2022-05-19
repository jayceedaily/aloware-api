<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Http\Request;
use App\Http\Requests\ThreadStoreRequest;
use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Container\BindingResolutionException;

class ThreadController extends Controller
{
    public function index(Request $request)
    {
        $threads = Thread::whereNull('parent_id')
                            ->withCount('replies')
                            ->with('author')
                            ->latest()
                            ->paginate();

        return response($threads);
    }

    /**
     *
     * @param ThreadStoreRequest $threadStoreRequest
     * @return Response|ResponseFactory
     * @throws ValidationException
     * @throws BindingResolutionException
     */
    public function store(ThreadStoreRequest $threadStoreRequest)
    {
        $thread = Thread::create($threadStoreRequest->validated());

        $thread->load('createdBy');

        return response($thread, 201);
    }
}
