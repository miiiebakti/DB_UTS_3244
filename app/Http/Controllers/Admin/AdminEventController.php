<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class AdminEventController extends Controller
{
public function index()
    {
    $events = Event::all();
    return view('admin.events', compact('events'));
    }
    public function create()
    {
        return view('admin.create-event');
    }
   public function store(Request $request)
{
    Event::create($request->all());

    return redirect('/admin/events');
} 
public function edit($id)
{
    $event = Event::findOrFail($id);

    return view('admin.edit-event', compact('event'));
}
public function update(Request $request, $id)
{
    $event = Event::findOrFail($id);
    $event->update($request->all());

    return redirect('/admin/events');
}
public function destroy($id)
{
    $event = Event::findOrFail($id);
    $event->delete();

    return redirect('/admin/events');
}
}

