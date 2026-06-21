<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function ticket(Request $request)
    {
        $transaction = Transaction::with('event')
            ->where('order_id', $request->order_id)
            ->firstOrFail();

        return view('ticket', compact('transaction'));
    }
}