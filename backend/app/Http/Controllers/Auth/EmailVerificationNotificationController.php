<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    use ApiResponse;

    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            // session-based authentication, di-off kan
//            return redirect()->intended('/dashboard');

            return $this->error(
                message: "Email already verified",
                statusCode: 200
            );
        }

        $request->user()->sendEmailVerificationNotification();

        // session-based authentication, di-off kan
//        return response()->json(['status' => 'verification-link-sent']);

        return $this->success(
            message: "Verification link sent",
        );
    }
}
