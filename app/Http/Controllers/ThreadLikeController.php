<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\ThreadLike;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;

class ThreadLikeController extends Controller
{
    /**
     * Like a thread
     *
     * @param Request $request
     * @param Thread $thread
     * @return Response|ResponseFactory
     * @throws BindingResolutionException
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function store(Request $request, Thread $thread)
    {
        if($request->user()->threadLikes()->where('thread_id', $thread->id)->exists())
        {
            return response(\trans("Thread already liked"));
        }

        $request->user()->threadLikes()->create([
            'thread_id' => $thread->id
        ]);

        return response(\trans("Thread has been liked"));
    }

    /**
     * Remove like from a thread
     *
     * @param Request $request
     * @param Thread $thread
     * @return Response|ResponseFactory
     * @throws BindingResolutionException
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function destroy(Request $request, Thread $thread)
    {
        $request->user()->threadLikes()->where('thread_id', $thread->id)->delete();

        return response(\trans("Thread has been disliked"));
    }
}
