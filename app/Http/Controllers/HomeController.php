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
        // Ambil semua kategori
        $categories = Category::all();

        // Query event
        $events = Event::query();

        // Filter berdasarkan kategori jika dipilih
        if ($request->filled('category')) {
            $events->where('category_id', $request->category);
        }

        // Ambil semua event
        $events = $events->get();

        // Ambil semua partner
        $partners = Partner::all();

        return view('welcome', compact(
            'events',
            'categories',
            'partners'
        ));
    }
}