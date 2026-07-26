<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::latest()->get();

        return view('admin.vouchers.index', compact('vouchers'));
    }

    public function create()
    {
        return view('admin.vouchers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:vouchers,code',
            'type' => 'required|in:percent,fixed',
            'value' => 'required|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'quota' => 'nullable|integer|min:1',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->type === 'percent' && $request->value > 100) {
            return back()
                ->withInput()
                ->withErrors([
                    'value' => 'Diskon persen tidak boleh lebih dari 100%.',
                ]);
        }

        Voucher::create([
            'code' => strtoupper($request->code),
            'type' => $request->type,
            'value' => $request->value,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'quota' => $request->quota,
            'used' => 0,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()
            ->route('admin.vouchers.index')
            ->with('success', 'Voucher berhasil ditambahkan.');
    }

    public function show(Voucher $voucher)
    {
        return redirect()->route('admin.vouchers.edit', $voucher);
    }

    public function edit(Voucher $voucher)
    {
        return view('admin.vouchers.edit', compact('voucher'));
    }

    public function update(Request $request, Voucher $voucher)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:vouchers,code,' . $voucher->id,
            'type' => 'required|in:percent,fixed',
            'value' => 'required|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'quota' => 'nullable|integer|min:1',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->type === 'percent' && $request->value > 100) {
            return back()
                ->withInput()
                ->withErrors([
                    'value' => 'Diskon persen tidak boleh lebih dari 100%.',
                ]);
        }

        $voucher->update([
            'code' => strtoupper($request->code),
            'type' => $request->type,
            'value' => $request->value,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'quota' => $request->quota,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()
            ->route('admin.vouchers.index')
            ->with('success', 'Voucher berhasil diperbarui.');
    }

    public function destroy(Voucher $voucher)
    {
        $voucher->delete();

        return redirect()
            ->route('admin.vouchers.index')
            ->with('success', 'Voucher berhasil dihapus.');
    }

    public function check(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'total' => 'required|numeric|min:0',
        ]);

        $voucher = Voucher::where('code', strtoupper($request->code))
            ->where('is_active', true)
            ->first();

        if (!$voucher) {
            return response()->json([
                'success' => false,
                'message' => 'Kode voucher tidak ditemukan atau tidak aktif.',
            ], 422);
        }

        $today = now()->startOfDay();

        if ($voucher->start_date && $today->lt($voucher->start_date)) {
            return response()->json([
                'success' => false,
                'message' => 'Voucher belum dapat digunakan.',
            ], 422);
        }

        if ($voucher->end_date && $today->gt($voucher->end_date)) {
            return response()->json([
                'success' => false,
                'message' => 'Voucher sudah kedaluwarsa.',
            ], 422);
        }

        if ($voucher->quota !== null && $voucher->used >= $voucher->quota) {
            return response()->json([
                'success' => false,
                'message' => 'Kuota voucher sudah habis.',
            ], 422);
        }

        $total = (float) $request->total;

        if ($voucher->type === 'percent') {
            $discount = $total * ((float) $voucher->value / 100);
        } else {
            $discount = (float) $voucher->value;
        }

        // Diskon tidak boleh lebih besar dari harga
        $discount = min($discount, $total);

        $finalTotal = $total - $discount;

        return response()->json([
            'success' => true,
            'message' => 'Voucher berhasil digunakan.',
            'voucher_id' => $voucher->id,
            'code' => $voucher->code,
            'discount' => $discount,
            'final_total' => $finalTotal,
        ]);
    }
}