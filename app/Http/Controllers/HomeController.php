<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Category;
use App\Models\Partner;

class HomeController extends Controller
{
   public function index(Request $request)
{
    $categories = Category::all();

    $events = Event::query();

    if ($request->category) {
        if ($request->category) {
    $events->where('category_id', $request->category);
}
    }

    $events = $events->get();
    $partners = Partner::all();
    
    return view('welcome', compact('events', 'categories', 'partners'));
}
}
