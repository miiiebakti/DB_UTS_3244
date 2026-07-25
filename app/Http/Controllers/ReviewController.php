<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Event $event)
    {
        if (!Auth::check() || Auth::user()->role !== 'customer') {
            return redirect()
                ->route('google.login', [
                    'event_id' => $event->id,
                    'login_action' => 'review',
                ]);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:1000',
        ]);

        Review::create([
            'event_id' => $event->id,
            'user_id' => Auth::id(),
            'name' => Auth::user()->name,
            'email' => Auth::user()->email,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return redirect()
            ->route('events.show', $event->id)
            ->with('success', 'Review berhasil dikirim!');
    }
}