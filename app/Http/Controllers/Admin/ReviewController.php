<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'superadmin') {

            $reviews = Review::with([
                'event',
                'user'
            ])
            ->latest()
            ->get();

        } else {

            $reviews = Review::with([
                'event',
                'user'
            ])
            ->whereHas('event', function ($query) use ($user) {

                $query->where(
                    'user_id',
                    $user->id
                );

            })
            ->latest()
            ->get();
        }

        return view(
            'admin.reviews.index',
            compact('reviews')
        );
    }
}