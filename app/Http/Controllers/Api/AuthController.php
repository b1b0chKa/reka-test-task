<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\UserAuthResource;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        private AuthService $authService,
    ) {}

    public function register(RegisterRequest $request)
    {
        $dto = $this->authService->register($request->validated());

        return response()->json([
            'status'    => true,
            'data'      => new UserAuthResource($dto),
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        try {
            $dto = $this->authService->login($request->validated());

            return response()->json([
                'status'    => true,
                'data'      => new UserAuthResource($dto)
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 401);
        }
    }
}
