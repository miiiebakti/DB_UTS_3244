<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\TicketPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketPriceController extends Controller
{
    public function index()
    {
       if (Auth::user()->role == 'superadmin') {

            $ticketPrices = TicketPrice::with('event')
                ->latest()
                ->get();

        } else {

            $ticketPrices = TicketPrice::with('event')
                ->whereHas('event', function ($query) {
                    $query->where('user_id', Auth::id());
                })
                ->latest()
                ->get();

        }

        return view(
            'admin.ticket_prices.index',
            compact('ticketPrices')
        );
    }

    public function create()
    {
       if (Auth::user()->role == 'superadmin') {

    $events = Event::orderBy('title')->get();

        } else {

            $events = Event::where('user_id', Auth::id())
                ->orderBy('title')
                ->get();

        }

        return view(
            'admin.ticket_prices.create',
            compact('events')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'name' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'quota' => 'nullable|integer|min:1',
            'is_active' => 'nullable|boolean',
        ]);

        if (Auth::user()->role != 'superadmin') {

            $event = Event::where('id', $request->event_id)
                ->where('user_id', Auth::id())
                ->first();

            if (!$event) {
                abort(403);
            }

        }

        TicketPrice::create([
            'event_id' => $request->event_id,
            'name' => $request->name,
            'price' => $request->price,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'quota' => $request->quota,
            'sold' => 0,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()
            ->route('admin.ticket-prices.index')
            ->with('success', 'Harga tiket berhasil ditambahkan.');
    }

    public function edit(TicketPrice $ticketPrice)
    {
        if (
    Auth::user()->role != 'superadmin' &&
            $ticketPrice->event->user_id != Auth::id()
        ) {
            abort(403);
        }

     if (Auth::user()->role == 'superadmin') {

    $events = Event::orderBy('title')->get();

        } else {

            $events = Event::where('user_id', Auth::id())
                ->orderBy('title')
                ->get();

        }

        return view(
            'admin.ticket_prices.edit',
            compact('ticketPrice', 'events')
        );
    }

    public function update(
        Request $request,
        TicketPrice $ticketPrice
    ) {

        if (
            Auth::user()->role != 'superadmin' &&
            $ticketPrice->event->user_id != Auth::id()
        ) {
            abort(403);
        }

        $request->validate([
            'event_id' => 'required|exists:events,id',
            'name' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'quota' => 'nullable|integer|min:1',
            'is_active' => 'nullable|boolean',
        ]);

        $ticketPrice->update([
            'event_id' => $request->event_id,
            'name' => $request->name,
            'price' => $request->price,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'quota' => $request->quota,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()
            ->route('admin.ticket-prices.index')
            ->with('success', 'Harga tiket berhasil diperbarui.');
    }

    public function destroy(TicketPrice $ticketPrice)
    {
        if (
            Auth::user()->role != 'superadmin' &&
            $ticketPrice->event->user_id != Auth::id()
        ) {
            abort(403);
        }

        $ticketPrice->delete();

        return redirect()
            ->route('admin.ticket-prices.index')
            ->with('success', 'Harga tiket berhasil dihapus.');
    }
}