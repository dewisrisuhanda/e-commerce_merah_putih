<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResponse;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    use ApiResponse;

    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): JsonResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            // session-based authentication, di-off kan
//            return redirect()->intended(
//                config('app.frontend_url').'/dashboard?verified=1'
//            );

            return $this->success(
                message: "Email already verified",
            );
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        // session-based authentication, di-off kan
//        return redirect()->intended(
//            config('app.frontend_url').'/dashboard?verified=1'
//        );

        return $this->success(
            message: "Email verification successful",
        );
    }
}
