<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthService
{
    public function register(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function login(array $data): array
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw new UnauthorizedHttpException('', 'Invalid credentials');
        }

        // Delete old tokens
        $user->tokens()->delete();

        $token = $user->createToken('api-token')->plainTextToken;

        return [
            'message' => 'Login successful',
            'token' => $token,
            'user' => new UserResource($user)
        ];
    }
}
