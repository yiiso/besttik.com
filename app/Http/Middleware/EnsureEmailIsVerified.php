<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && !Auth::user()->hasVerifiedEmail()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => __('messages.verification_required'),
                    'requires_verification' => true
                ], 403);
            }

            return redirect()->route('verification.notice')
                ->with('error', __('messages.verification_required'));
        }

        return $next($request);
    }
}