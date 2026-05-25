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
        $category = Category::where('slug', $request->category)->first();

        if ($category) {
            $events->where('category_id', $category->id);
        }
    }

    $events = $events->get();
    $partners = Partner::all();
    
    return view('welcome', compact('events', 'categories', 'partners'));
}
}
