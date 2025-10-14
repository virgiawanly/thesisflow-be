<?php

namespace App\Http\Controllers\V1\Auth;

use App\Helpers\ResponseHelper;
use App\Services\AuthService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\BasicLoginRequest;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected AuthService $authService) {}

    /**
     * Basic login user using username and password.
     * 
     * @param  \App\Http\Requests\Api\V1\Auth\BasicLoginRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(BasicLoginRequest $request)
    {
        $results = $this->authService->basicLogin($request->validated());

        return ResponseHelper::success(trans('auth.login_success'), $results, 200);
    }
}
