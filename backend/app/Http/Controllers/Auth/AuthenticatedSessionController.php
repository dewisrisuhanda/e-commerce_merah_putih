<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    use ApiResponse;

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        $request->authenticate();

        // session-based authentication, di-off kan
        // $request->session()->regenerate();

        $user = $request->user();
        $user->tokens()->delete();
        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->success(
            data: [
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user,
            ],
            message: "Login successful"
        );
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): \Illuminate\Http\JsonResponse
    {

        // session-based authentication, di-off kan
//        Auth::guard('web')->logout();
//        $request->session()->invalidate();
//        $request->session()->regenerateToken();


        $token = $request->user()->currentAccessToken();
//        if ($token instanceof \Laravel\Sanctum\PersonalAccessToken) {
//            $token->delete();
//        }
//        $request->user()->currentAccessToken()->delete();

        if ($token instanceof \Laravel\Sanctum\PersonalAccessToken) {
            $token->delete();
        } else {
            // fallback: hapus semua token (untuk safety)
            $request->user()->tokens()->delete();
        }

        return $this->success(
            message: "Logout successful"
        );
    }
}
