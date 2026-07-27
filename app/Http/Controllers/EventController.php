<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function event(Request $request)
    {
        $categories = Category::all();

        $events = Event::when(
            $request->category,
            function ($query) use ($request) {
                $query->where('category_id', $request->category);
            }
        )->get();

        return view(
            'welcome',
            compact(
                'events',
                'categories'
            )
        );
    }

    public function show(Event $event)
    {
        $categories = Category::all();

        // Ambil semua review event
        $reviews = Review::with('user')
            ->where('event_id', $event->id)
            ->latest()
            ->get();

        // Cek apakah user yang login sudah pernah review
        $userReview = null;

        if (Auth::check()) {
            $userReview = Review::where('event_id', $event->id)
                ->where('user_id', Auth::id())
                ->first();
        }

        return view(
            'event-detail',
            compact(
                'event',
                'categories',
                'reviews',
                'userReview'
            )
        );
    }

    public function checkout()
    {
        return redirect()->route('event');
    }
}