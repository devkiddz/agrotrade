<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckBannedUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Check if user is banned/blocked/disabled
            if (in_array($user->status, ['blocked', 'banned', 'disabled'])) {
                // Store user info before logout
                $userName = $user->name;
                $userEmail = $user->email;
                $bannedReason = $this->getBannedReason($user->status);

                // Proper logout method that works with all guard types
                Auth::guard('web')->logout();

                // Invalidate the session
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                // Redirect to blocked account page with user information
                return redirect()->route('account.blocked')
                    ->with('user_name', $userName)
                    ->with('user_email', $userEmail)
                    ->with('banned_reason', $bannedReason);
            }
        }

        return $next($request);
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
