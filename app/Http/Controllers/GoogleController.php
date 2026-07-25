<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
        // Simpan event yang sedang dibuka
        if (request()->has('event_id')) {
            session(['event_id' => request('event_id')]);
        }

        // Tampilkan pilihan akun Google
        return Socialite::driver('google')
            ->with([
                'prompt' => 'select_account'
            ])
            ->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')
            ->stateless()
            ->user();

        // Cari user berdasarkan email Google.
        // Kalau belum ada, buat user baru.
        $user = User::updateOrCreate(
            [
                'email' => $googleUser->getEmail(),
            ],
            [
                'name' => $googleUser->getName(),
                'password' => bcrypt(str()->random(16)),
            ]
        );

        // Login sebagai user Google
        Auth::login($user);

        // Simpan data customer untuk kebutuhan checkout
        session([
            'customer_name' => $googleUser->getName(),
            'customer_email' => $googleUser->getEmail(),
        ]);

        // Kembali ke event yang tadi dibuka
        $eventId = session('event_id');

        if ($eventId) {
            session()->forget('event_id');

            return redirect()->route('events.show', $eventId);
        }

        return redirect()->route('home');
    }
}