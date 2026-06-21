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

    $events = Event::when($request->category, function ($query) use ($request) {
        $query->where('category_id', $request->category);
    })->get();

    return view('welcome', compact('events', 'categories'));
}
	
    public function show(Event $event)
{
    $categories = Category::all();

    return view('event-detail', compact('event', 'categories'));
}

	public function checkout()
    {
        return view('checkout');
    }
}
