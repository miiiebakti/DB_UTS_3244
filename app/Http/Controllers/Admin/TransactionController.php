<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
  public function index(Request $request)
{
    $query = Transaction::with('event');

    // Jika login sebagai organizer,
    // hanya tampilkan transaksi dari event miliknya
    if (Auth::user()->role == 'organizer') {

        $query->whereHas('event', function ($q) {
            $q->where('user_id', Auth::id());
        });

    }

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


public function exportPdf(Request $request)
{
    $query = Transaction::with('event');

    // Organizer hanya melihat transaksi event miliknya
    if (Auth::user()->role == 'organizer') {
        $query->whereHas('event', function ($q) {
            $q->where('user_id', Auth::id());
        });
    }

    // Search
    if ($request->search) {
        $query->where(function ($q) use ($request) {
            $q->where('order_id', 'like', '%' . $request->search . '%')
              ->orWhere('customer_name', 'like', '%' . $request->search . '%')
              ->orWhere('customer_email', 'like', '%' . $request->search . '%');
        });
    }

    // Status
    if ($request->status && $request->status != 'all') {
        $query->where('status', $request->status);
    }

    // Bulan
    if ($request->month == 'this_month') {
        $query->whereMonth('created_at', now()->month)
              ->whereYear('created_at', now()->year);
    }

    if ($request->month == 'last_month') {
        $query->whereMonth('created_at', now()->subMonth()->month)
              ->whereYear('created_at', now()->subMonth()->year);
    }

    $transactions = $query->latest()->get();

    $pdf = Pdf::loadView(
        'admin.transactions.pdf',
        compact('transactions')
    );

    return $pdf->download('laporan-transaksi.pdf');
}

public function certificate(Transaction $transaction)
{
    if ($transaction->status != 'settlement' &&
        $transaction->status != 'success') {

        abort(403, 'Peserta belum menyelesaikan pembayaran.');
    }

    $pdf = Pdf::loadView('admin.certificate', compact('transaction'));

    return $pdf->download(
        'certificate-'.$transaction->order_id.'.pdf'
    );
}

}