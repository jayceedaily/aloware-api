<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserFollower;
use Illuminate\Http\Request;

class UserFollowerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
        return $user->followers()
                    ->latest()
                    ->paginate();
    }
}
