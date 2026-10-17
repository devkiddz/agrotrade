<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Http\Request;

class LoginResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        $user = $request->user();

        // Check if user is banned/blocked/disabled
        if ($user && in_array($user->status, ['blocked', 'banned', 'disabled'])) {
            // Store user info before logout
            $userName = $user->name;
            $userEmail = $user->email;
            $bannedReason = $this->getBannedReason($user->status);

            // Proper logout method that works with all guard types
            auth()->guard('web')->logout();

            // Invalidate the session
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Redirect to blocked account page
            return $request->wantsJson()
                ? new JsonResponse(['message' => 'Account is temporarily locked.'], 423)
                : redirect()->route('account.blocked')
                    ->with('user_name', $userName)
                    ->with('user_email', $userEmail)
                    ->with('banned_reason', $bannedReason);
        }

        return $request->wantsJson()
            ? new JsonResponse([], 200)
            : redirect()->intended(config('fortify.home'));
    }    /**
     * Get a user-friendly reason for the ban
     */
    private function getBannedReason($status)
    {
        switch ($status) {
            case 'banned':
                return 'Your account has been banned due to security concerns.';
            case 'disabled':
                return 'Your account has been temporarily disabled.';
            case 'blocked':
                return 'Your account has been blocked for security verification.';
            default:
                return 'Your account access has been restricted.';
        }
    }
}
