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
        $threads = Thread::fromFollowing($request->user())
                            ->with('createdBy')
                            ->with('shared.createdBy')
                            ->with('shared.shared.createdBy')
                            ->with('parent.createdBy')
                            ->withCount(['replies','likes'])
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

    public function show(Thread $thread)
    {
        $thread->load('createdBy');

        $thread->loadCount(['replies','likes']);

        return response($thread);
    }
}



/**
     * Get Eloquent query with bindings
     */
    function get_eloquent_sql_with_bindings($query)
    {
        return vsprintf(str_replace('?', '%s', $query->toSql()), collect($query->getBindings())->map(function ($binding) {
            return is_numeric($binding) ? $binding : "'{$binding}'";
        })->toArray());
    }
