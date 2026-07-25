<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Email atau Password salah.',
            ])->withInput();
        }

        if (!in_array($user->role, ['superadmin', 'organizer'])) {
            return back()->withErrors([
                'email' => 'Akun ini bukan akun admin atau organizer.',
            ])->withInput();
        }

        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'email' => 'Email atau Password salah.',
            ])->withInput();
        }

        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}