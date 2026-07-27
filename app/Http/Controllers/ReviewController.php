<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReviewController extends Controller
{
    public function store(Request $request, Event $event)
    {
        // Harus login sebagai customer
        if (!Auth::check() || Auth::user()->role !== 'customer') {
            return redirect()->route('google.login', [
                'event_id' => $event->id,
                'login_action' => 'review',
            ]);
        }

        // Review hanya bisa diberikan H+1 setelah event selesai
        if (now()->lt(Carbon::parse($event->date)->addDay())) {
            return redirect()
                ->route('events.show', $event->id)
                ->with('error', 'Review hanya dapat diberikan sehari setelah acara selesai.');
        }

        // Cek apakah user sudah pernah memberikan review
        $existingReview = Review::where('event_id', $event->id)
            ->where('user_id', Auth::id())
            ->exists();

        if ($existingReview) {
            return redirect()
                ->route('events.show', $event->id)
                ->with('error', 'Anda sudah memberikan review untuk event ini.');
        }

        // Validasi input
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:1000',
        ]);

        // Simpan review
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