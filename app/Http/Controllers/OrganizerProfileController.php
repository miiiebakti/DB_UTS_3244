<?php

namespace App\Http\Controllers;

use App\Models\User;

class OrganizerProfileController extends Controller
{
    public function show(User $user)
    {
        abort_unless($user->role === 'organizer', 404);

        $events = $user->events()
            ->with('reviews')
            ->get();

        $reviews = $events
            ->flatMap(function ($event) {
                return $event->reviews;
            })
            ->sortByDesc('created_at');

        $totalReview = $reviews->count();

        $averageRating = $totalReview > 0
            ? round($reviews->avg('rating'), 1)
            : 0;

        return view('organizer.profile', compact(
            'user',
            'events',
            'reviews',
            'totalReview',
            'averageRating'
        ));
    }
}