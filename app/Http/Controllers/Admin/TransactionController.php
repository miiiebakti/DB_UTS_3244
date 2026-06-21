<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
  public function index(Request $request)
{
    $query = Transaction::with('event');

    // SEARCH
    if ($request->search) {
        $query->where(function ($q) use ($request) {
            $q->where('order_id', 'like', '%' . $request->search . '%')
              ->orWhere('customer_name', 'like', '%' . $request->search . '%')
              ->orWhere('customer_email', 'like', '%' . $request->search . '%');
        });
    }

    // STATUS FILTER
    if ($request->status && $request->status != 'all') {
        $query->where('status', $request->status);
    }

    // MONTH FILTER
    if ($request->month == 'this_month') {
        $query->whereMonth('created_at', now()->month)
              ->whereYear('created_at', now()->year);
    }

    if ($request->month == 'last_month') {
        $query->whereMonth('created_at', now()->subMonth()->month)
              ->whereYear('created_at', now()->subMonth()->year);
    }

    $transactions = $query
        ->latest()
        ->paginate(20)
        ->withQueryString();

   return view('admin.transactions.index', compact('transactions'));
}
}