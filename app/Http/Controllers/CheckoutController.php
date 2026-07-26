<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Transaction;
use App\Models\Category;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function create(Event $event)
    {
        session([
            'event_id' => $event->id
        ]);

        $categories = Category::all();

        return view(
            'checkout.create',
            compact(
                'event',
                'categories'
            )
        );
    }

    public function checkVoucher(Request $request, Event $event)
    {
        $request->validate([
            'code' => 'required|string|max:50',
        ]);

        $voucher = Voucher::where(
            'code',
            strtoupper(trim($request->code))
        )
        ->where('is_active', true)
        ->first();

        if (!$voucher) {

            return response()->json([
                'success' => false,
                'message' => 'Kode voucher tidak ditemukan atau tidak aktif.'
            ], 422);

        }

        $today = now()->startOfDay();

        if (
            $voucher->start_date &&
            $today->lt($voucher->start_date)
        ) {

            return response()->json([
                'success' => false,
                'message' => 'Voucher belum dapat digunakan.'
            ], 422);

        }

        if (
            $voucher->end_date &&
            $today->gt($voucher->end_date)
        ) {

            return response()->json([
                'success' => false,
                'message' => 'Voucher sudah kedaluwarsa.'
            ], 422);

        }

        if (
            $voucher->quota !== null &&
            $voucher->used >= $voucher->quota
        ) {

            return response()->json([
                'success' => false,
                'message' => 'Kuota voucher sudah habis.'
            ], 422);

        }

        $currentTicket = $event->current_ticket_price;

    if (!$currentTicket) {
            return response()->json([
                'success' => false,
                'message' => 'Belum ada harga tiket yang aktif.'
            ], 422);
        }

$ticketPrice = (float) $currentTicket->price;
        $serviceFee = 5000;

        $subtotal = $ticketPrice + $serviceFee;

        if ($voucher->type === 'percent') {

            $discount = $subtotal *
                ((float) $voucher->value / 100);

        } else {

            $discount = (float) $voucher->value;

        }

        $discount = min(
            $discount,
            $subtotal
        );

        $finalTotal = $subtotal - $discount;

        return response()->json([
            'success' => true,
            'message' => 'Voucher berhasil digunakan.',
            'code' => $voucher->code,
            'discount' => $discount,
            'final_total' => $finalTotal,
        ]);
    }

    public function store(Request $request, Event $event)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'voucher_code' => 'nullable|string|max:50',
        ]);

        if ($event->stock <= 0) {

            return back()->with(
                'error',
                'Mohon maaf, tiket untuk acara ini sudah habis.'
            );

        }
        
        $currentTicket = $event->current_ticket_price;

        if (!$currentTicket) {
            return back()->with(
                'error',
                'Belum ada harga tiket yang aktif.'
            );
        }

        $ticketPrice = (float) $currentTicket->price;
        $serviceFee = 5000;

        $discount = 0;
        $voucher = null;

        if ($request->filled('voucher_code')) {

            $voucher = Voucher::where(
                'code',
                strtoupper(trim($request->voucher_code))
            )
            ->where('is_active', true)
            ->first();

            if (!$voucher) {

                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Kode voucher tidak ditemukan atau tidak aktif.'
                    );

            }

            $today = now()->startOfDay();

            if (
                $voucher->start_date &&
                $today->lt($voucher->start_date)
            ) {

                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Voucher belum dapat digunakan.'
                    );

            }

            if (
                $voucher->end_date &&
                $today->gt($voucher->end_date)
            ) {

                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Voucher sudah kedaluwarsa.'
                    );

            }

            if (
                $voucher->quota !== null &&
                $voucher->used >= $voucher->quota
            ) {

                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Kuota voucher sudah habis.'
                    );

            }

            $subtotal = $ticketPrice + $serviceFee;

            if ($voucher->type === 'percent') {

                $discount = $subtotal *
                    ((float) $voucher->value / 100);

            } else {

                $discount = (float) $voucher->value;

            }

            $discount = min(
                $discount,
                $subtotal
            );
        }

        $totalPrice =
            $ticketPrice +
            $serviceFee -
            $discount;

        if ($totalPrice < 0) {
            $totalPrice = 0;
        }

        $orderId =
            'TRX-' .
            time() .
            '-' .
            Str::random(5);

        $transaction = Transaction::create([
            'event_id' => $event->id,
            'order_id' => $orderId,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        if ($voucher) {

            $voucher->increment('used');

        }

        \Midtrans\Config::$serverKey =
            env('MIDTRANS_SERVER_KEY');

        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = [

            'transaction_details' => [

                'order_id' => $orderId,

                'gross_amount' => (int) $totalPrice,

            ],

            'customer_details' => [

                'first_name' =>
                    $request->customer_name,

                'email' =>
                    $request->customer_email,

                'phone' =>
                    $request->customer_phone,

            ],

        ];

        try {

            $snapToken =
                \Midtrans\Snap::getSnapToken($params);

            $transaction->update([
                'snap_token' => $snapToken
            ]);

            return redirect()->route(
                'checkout.payment',
                $transaction->order_id
            );

        } catch (\Exception $e) {

            if ($voucher) {
                $voucher->decrement('used');
            }

            $transaction->delete();

            return back()
                ->withInput()
                ->with(
                    'error',
                    $e->getMessage()
                );
        }
    }

    public function payment($order_id)
    {
        $categories = Category::all();

        $transaction = Transaction::with('event')
            ->where('order_id', $order_id)
            ->firstOrFail();

        return view(
            'checkout.payment',
            compact(
                'transaction',
                'categories'
            )
        );
    }

    public function success($order_id)
    {
        $categories = Category::all();

        $transaction = Transaction::with('event')
            ->where('order_id', $order_id)
            ->firstOrFail();

        \Midtrans\Config::$serverKey =
            env('MIDTRANS_SERVER_KEY');

        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        try {

            $status =
                \Midtrans\Transaction::status($order_id);

            if ($status) {

                $trx_status = is_array($status)
                    ? ($status['transaction_status'] ?? '')
                    : ($status->transaction_status ?? '');

                if (in_array($trx_status, [
                    'settlement',
                    'capture'
                ])) {

                    if (
                        strtolower(
                            $transaction->status
                        ) === 'pending'
                    ) {

                        $transaction->update([
                            'status' => 'success'
                        ]);

                        if (
                            $transaction->event &&
                            $transaction->event->stock > 0
                        ) {

                            $transaction->event->stock =
                                $transaction->event->stock - 1;

                            $transaction->event->save();

                            $currentTicket = $transaction->event->current_ticket_price;

                            if ($currentTicket) {
                                $currentTicket->increment('sold');
                            }
                            
                            try {

                                \Illuminate\Support\Facades\Mail::to(
                                    $transaction->customer_email
                                )->send(
                                    new \App\Mail\EventTicketMail(
                                        $transaction
                                    )
                                );

                            } catch (\Exception $e) {

                                \Log::error(
                                    'Gagal mengirim email E-Ticket: ' .
                                    $e->getMessage()
                                );

                            }

                        }

                    }

                }

            }

        } catch (\Exception $e) {

            return redirect()
                ->route('home')
                ->with(
                    'error',
                    'Transaksi tidak ditemukan atau gagal diproses oleh sistem pembayaran.'
                );

        }

        return view(
            'checkout.success',
            compact(
                'transaction',
                'categories'
            )
        );
    }
}