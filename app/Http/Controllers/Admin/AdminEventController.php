<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;



class AdminEventController extends Controller
{
    public function index()
    {
        if (Auth::user()->role == 'superadmin') {

            $events = Event::all();

        } else {

            $events = Event::where('user_id', Auth::id())->get();

        }

        return view('admin.events', compact('events'));
    }

   public function create()
    {
        $categories = Category::all();

        return view('admin.create-event', compact('categories'));
    }

   public function store(Request $request)
{
    $data = $request->validate([
        'category_id' => 'required|exists:categories,id',
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'date' => 'required|date',
        'location' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|numeric|min:1',
        'poster' => 'nullable|image|max:2048'
    ]);

    if ($request->hasFile('poster')) {
        $data['poster_path'] = $request
            ->file('poster')
            ->store('posters', 'public');
    }

    $data['user_id'] = Auth::id();

    Event::create($data);

    return redirect('/admin/events');
}
public function edit($id)
{
    if (Auth::user()->role == 'superadmin') {

    $event = Event::findOrFail($id);

} else {

    $event = Event::where('id', $id)
        ->where('user_id', Auth::id())
        ->firstOrFail();

}

$categories = Category::all();

return view('admin.edit-event', compact('event', 'categories'));

    $categories = Category::all();

    return view('admin.edit-event', compact('event', 'categories'));
}

public function update(Request $request, $id)
{
   if (Auth::user()->role == 'superadmin') {

    $event = Event::findOrFail($id);

} else {

    $event = Event::where('id', $id)
        ->where('user_id', Auth::id())
        ->firstOrFail();

}

    $data = $request->validate([
        'category_id' => 'required|exists:categories,id',
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'date' => 'required|date',
        'location' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|numeric|min:1',
        'poster' => 'nullable|image|max:2048'
    ]);

    if ($request->hasFile('poster')) {

        if ($event->poster_path) {
            Storage::disk('public')
                ->delete($event->poster_path);
        }

        $data['poster_path'] = $request
            ->file('poster')
            ->store('posters', 'public');
    }

    $event->update($data);

    return redirect('/admin/events');
}

public function destroy($id)
{
    if (Auth::user()->role == 'superadmin') {

        $event = Event::findOrFail($id);

    } else {

        $event = Event::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

    }

    if ($event->poster_path) {
        Storage::disk('public')
            ->delete($event->poster_path);
    }

    $event->delete();

    return redirect('/admin/events');
}
}

