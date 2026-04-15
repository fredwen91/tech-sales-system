<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService) {}

    public function login(LoginRequest $request): JsonResponse
    {
        $res = $this->authService->login($request->validated());

        return response()->json($res);
    }

    public function me(): JsonResponse
    {
        return response()->json(new UserResource(Auth::user()));
    }

    public function logout(): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $user->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}
