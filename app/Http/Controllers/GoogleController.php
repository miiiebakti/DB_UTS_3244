<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect(Request $request)
    {
        if ($request->filled('event_id')) {
            session([
                'event_id' => $request->event_id
            ]);
        }

        if ($request->filled('login_action')) {
            session([
                'login_action' => $request->login_action
            ]);
        }

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

        $user = User::where(
            'email',
            $googleUser->getEmail()
        )->first();

        /*
        |--------------------------------------------------------------------------
        | Admin / Organizer tidak boleh login customer
        |--------------------------------------------------------------------------
        */

        if ($user && in_array($user->role, [
            'superadmin',
            'organizer'
        ])) {

            return redirect()
                ->route('login')
                ->with(
                    'error',
                    'Akun ini merupakan akun admin/organizer.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Buat customer jika belum ada
        |--------------------------------------------------------------------------
        */

        if (!$user) {

            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'password' => bcrypt(str()->random(16)),
                'role' => 'customer',
            ]);

        } else {

            $user->update([
                'name' => $googleUser->getName(),
                'role' => 'customer',
            ]);

        }

        /*
        |--------------------------------------------------------------------------
        | Login Customer
        |--------------------------------------------------------------------------
        */

        Auth::login($user);

        session([
            'customer_name' => $user->name,
            'customer_email' => $user->email,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Jika berasal dari Checkout
        |--------------------------------------------------------------------------
        */

        if (session('login_action') === 'checkout' && session()->has('event_id')) {

            $eventId = session('event_id');

            session()->forget([
                'login_action',
                'event_id'
            ]);

            return redirect()->route('checkout.create', $eventId);
        }

        /*
        |--------------------------------------------------------------------------
        | Jika berasal dari Review
        |--------------------------------------------------------------------------
        */

        if (session('login_action') === 'review' && session()->has('review_event_id')) {

            $eventId = session('review_event_id');

            session()->forget([
                'login_action',
                'review_event_id'
            ]);

            return redirect()->route('events.show', $eventId);
        }

        return redirect()->route('home');
    }
}