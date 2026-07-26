<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\TicketType;
use Illuminate\Http\Request;

class TicketTypeController extends Controller
{
    public function index(Event $event)
    {
        $ticketTypes = $event->ticketTypes()
            ->orderBy('start_date')
            ->get();

        return view('admin.ticket-types.index', compact(
            'event',
            'ticketTypes'
        ));
    }

    public function create(Event $event)
    {
        return view('admin.ticket-types.create', compact('event'));
    }

    public function store(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'stock' => 'required|integer|min:0',
        ]);

        $event->ticketTypes()->create($validated);

        return redirect()
            ->route('admin.ticket-types.index', $event->id)
            ->with('success', 'Kategori tiket berhasil ditambahkan.');
    }

    public function edit(Event $event, TicketType $ticketType)
    {
        abort_unless(
            $ticketType->event_id === $event->id,
            404
        );

        return view('admin.ticket-types.edit', compact(
            'event',
            'ticketType'
        ));
    }

    public function update(
        Request $request,
        Event $event,
        TicketType $ticketType
    ) {
        abort_unless(
            $ticketType->event_id === $event->id,
            404
        );

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'stock' => 'required|integer|min:0',
        ]);

        $ticketType->update($validated);

        return redirect()
            ->route('admin.ticket-types.index', $event->id)
            ->with('success', 'Kategori tiket berhasil diperbarui.');
    }

    public function destroy(
        Event $event,
        TicketType $ticketType
    ) {
        abort_unless(
            $ticketType->event_id === $event->id,
            404
        );

        $ticketType->delete();

        return back()->with(
            'success',
            'Kategori tiket berhasil dihapus.'
        );
    }
}