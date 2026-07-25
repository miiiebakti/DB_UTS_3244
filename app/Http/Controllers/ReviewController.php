<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Event $event)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:1000',
        ]);

        Review::create([
            'event_id' => $event->id,
            'user_id' => auth()->id(),
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Review berhasil dikirim.');
    }
}