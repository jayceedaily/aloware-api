<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserFollower;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserFollowingController extends Controller
{
    /**
     * List of following
     *
     * @param Request $request
     * @param User $user
     * @return Response|ResponseFactory
     * @throws BindingResolutionException
     */
    public function index(Request $request, User $user)
    {
        $followers = $user->following()
                        ->latest()
                        ->paginate();

        return response($followers);
    }

    /**
     * Follow a user
     *
     * @param Request $request
     * @param User $user
     * @return void
     */
    public function store(Request $request, User $user)
    {
        UserFollower::create([
            'follower_id'   => $request->user()->id,
            'following_id'  => $user->id,
        ]);

        return response(['message' => trans('Follow was succesful')]);
    }

    /**
     * Unfollow a user
     *
     * @param Request $request
     * @param User $user
     * @return void
     */
    public function destroy(Request $request, User $user)
    {
        UserFollower::where('follower_id', $request->users()->id)
                    ->where('following_id', $user->id)
                    ->destroy();

        return response(['message' => trans('Unfollow was succesful')]);
    }
}
