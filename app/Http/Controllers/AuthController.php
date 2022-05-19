<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLoginRequest;
use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Create new token
     *
     * @param AuthLoginRequest $request
     * @return Response|ResponseFactory
     * @throws ValidationException
     * @throws BindingResolutionException
     */
    public function login(AuthLoginRequest $request)
    {
        $user = User::where('email', $request->validated('email'))->first();

        if (! $user || ! Hash::check($request->validated('password'), $user->password)) {
           return response(['errors'=> ['email' => [trans('The provided credentials are incorrect')]]], 422);
        }

        return response([
            'token' =>$user->createToken('app')->plainTextToken
        ], 201);
    }

    /**
     * Destroy current token
     *
     * @param Request $request
     * @return Response|ResponseFactory
     * @throws BindingResolutionException
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response([
            'message'=> 'Token deleted'
        ]);
    }
}
