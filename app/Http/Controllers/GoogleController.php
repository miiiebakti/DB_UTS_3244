<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        session([
            'customer_name' => $googleUser->getName(),
            'customer_email' => $googleUser->getEmail(),
        ]);

        $eventId = session('event_id');

return redirect()->route('checkout.create', $eventId);
    }
}