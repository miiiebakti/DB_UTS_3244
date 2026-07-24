<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function event(Request $request)
    {
        $categories = Category::all();

        $events = Event::when($request->category,function($query) use ($request){
            $query->where('category_id',$request->category);
        })->get();

        return view('welcome',compact(
            'events',
            'categories'
        ));
    }

    public function show(Event $event)
    {
        $categories = Category::all();

        if(\Schema::hasTable('reviews')){

            $reviews = $event->reviews()
                        ->latest()
                        ->get();

            $averageRating = round(
                $event->reviews()->avg('rating'),
                1
            );

            $totalReview = $event->reviews()->count();

        }else{

            $reviews = collect();

            $averageRating = 0;

            $totalReview = 0;

        }

        return view(
            'event-detail',
            compact(
                'event',
                'categories',
                'reviews',
                'averageRating',
                'totalReview'
            )
        );
    }

    public function checkout()
    {
        return view('checkout');
    }
}