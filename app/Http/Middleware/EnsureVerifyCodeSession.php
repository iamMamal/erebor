<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureVerifyCodeSession
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // اگه کاربر از مسیر درست نیومده (یعنی session خالیه)
        if (!session()->has('register_data.mobile')) {
            return redirect()->route('register');
        }

        return $next($request);
    }
}
