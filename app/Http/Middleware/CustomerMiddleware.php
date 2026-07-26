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
        // Belum login
        if (!Auth::check()) {

            session([
                'event_id' => $request->route('event')?->id,
            ]);

            return redirect()->route('google.login');
        }

        // Login tapi bukan customer
        if (Auth::user()->role !== 'customer') {

            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            session([
                'event_id' => $request->route('event')?->id,
            ]);

            return redirect()
                ->route('google.login')
                ->with(
                    'error',
                    'Silakan login menggunakan akun customer.'
                );
        }

        return $next($request);
    }
}