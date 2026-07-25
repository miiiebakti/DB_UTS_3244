<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CustomerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()
                ->route('google.login', [
                    'event_id' => $request->route('event')?->id
                ]);
        }

        if (Auth::user()->role !== 'customer') {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('google.login', [
                    'event_id' => $request->route('event')?->id
                ])
                ->with(
                    'error',
                    'Silakan login menggunakan akun customer.'
                );
        }

        return $next($request);
    }
}