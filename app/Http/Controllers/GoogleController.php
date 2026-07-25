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
        if ($request->has('event_id')) {
            session([
                'event_id' => $request->event_id
            ]);
        }

        if ($request->has('login_action')) {
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
        | JIKA EMAIL SUDAH DIPAKAI ADMIN / ORGANIZER
        |--------------------------------------------------------------------------
        */

        if ($user && in_array($user->role, [
            'superadmin',
            'organizer'
        ])) {

            return redirect()
                ->route('google.login')
                ->with(
                    'error',
                    'Akun ini merupakan akun admin/organizer. Silakan gunakan akun customer.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | JIKA USER BELUM ADA
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
        | LOGIN CUSTOMER
        |--------------------------------------------------------------------------
        */

        Auth::login($user);

        session([
            'customer_name' => $user->name,
            'customer_email' => $user->email,
        ]);


        /*
        |--------------------------------------------------------------------------
        | JIKA LOGIN UNTUK CHECKOUT
        |--------------------------------------------------------------------------
        */

        $eventId = session('event_id');

        if ($eventId) {

            session()->forget('event_id');

            return redirect()
                ->route('checkout.create', $eventId);
        }


        /*
        |--------------------------------------------------------------------------
        | JIKA LOGIN UNTUK REVIEW
        |--------------------------------------------------------------------------
        */

        $loginAction = session('login_action');

        if ($loginAction === 'review') {

            session()->forget('login_action');

            return redirect()
                ->route('events.show', session('review_event_id'));
        }


        return redirect()->route('home');
    }
}