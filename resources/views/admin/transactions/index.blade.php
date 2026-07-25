@extends('layouts.admin')

@section('content')
  
    <main class="flex-1 p-10 overflow-y-auto">
        <header class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-3xl font-black">Laporan Transaksi</h1>
                <p class="text-slate-500 font-medium">Pantau arus kas dan penjualan tiket Anda.</p>
            </div>
            <div class="flex gap-4">
                <button
                    class="px-6 py-3 border-2 border-slate-200 rounded-2xl font-bold hover:bg-white hover:border-indigo-600 hover:text-indigo-600 transition">
                    Ekspor Excel
                </button>
                <a href="{{ route('transactions.pdf', request()->query()) }}"
   class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg hover:bg-indigo-700 transition">
    Unduh PDF
</a>
            </div>
        </header>

        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
           <div class="px-8 py-6 bg-slate-50/50 border-b">

    <form method="GET"
          action="{{ route('transactions.index') }}"
          class="flex flex-wrap gap-4 items-center">

        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Cari Order ID, Nama, atau Email..."
            class="flex-1 px-5 py-3 rounded-xl border">

        <select name="status"
                class="px-5 py-3 rounded-xl border">

            <option value="all">Semua Status</option>

            <option value="Pending"
                {{ request('status') == 'Pending' ? 'selected' : '' }}>
                Pending
            </option>

            <option value="Success"
                {{ request('status') == 'Success' ? 'selected' : '' }}>
                Success
            </option>

        </select>

        <select name="month"
                class="px-5 py-3 rounded-xl border">

            <option value="">Semua</option>

            <option value="this_month"
                {{ request('month') == 'this_month' ? 'selected' : '' }}>
                Bulan Ini
            </option>

            <option value="last_month"
                {{ request('month') == 'last_month' ? 'selected' : '' }}>
                Bulan Lalu
            </option>

        </select>

        <button type="submit"
            class="px-5 py-3 bg-indigo-600 text-white rounded-xl font-bold">
            Filter
        </button>

    </form>

</div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                        <tr>
                            <th class="px-8 py-4">Order ID</th>
                            <th class="px-8 py-4">Detail Pembeli</th>
                            <th class="px-8 py-4">Event</th>
                            <th class="px-8 py-4">Tgl Transaksi</th>
                            <th class="px-8 py-4">Status</th>
                            <th class="px-8 py-4 text-right">Total Tagihan</th>
                            <th class="px-8 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    
                    <tbody class="divide-y border-t">

    @forelse($transactions as $trx)

    <tr class="hover:bg-slate-50 transition">

        <td class="px-8 py-6">
            <span class="font-mono font-bold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-lg text-sm">
                {{ $trx->order_id }}
            </span>
        </td>

        <td class="px-8 py-6">
            <p class="font-bold text-slate-800">
                {{ $trx->customer_name }}
            </p>

            <p class="text-xs text-slate-500">
                {{ $trx->customer_email }}
                <br>
                {{ $trx->customer_phone }}
            </p>
        </td>

        <td class="px-8 py-6">
            <p class="font-medium text-slate-700">
                {{ $trx->event->title ?? '-' }}
            </p>
        </td>

        <td class="px-8 py-6 text-sm text-slate-500">
            {{ $trx->created_at->format('d M Y, H:i') }}
        </td>

        <td class="px-8 py-6">

            @if($trx->status == 'Pending')

                <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-lg text-xs font-bold uppercase">
                    Pending
                </span>

            @elseif($trx->status == 'Success')

                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-bold uppercase">
                    Success
                </span>

            @else

                <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-xs font-bold uppercase">
                    {{ $trx->status }}
                </span>

            @endif

        </td>

        <td class="px-8 py-6 text-right font-black text-slate-900">
    Rp {{ number_format($trx->total_price,0,',','.') }}
</td>

<td class="px-8 py-6 text-center">

    @if(in_array($trx->status, ['Success', 'success', 'settlement']))

        <a href="{{ route('transactions.certificate', $trx->id) }}"
           class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-xl hover:bg-green-700 transition">

            📄 Certificate

        </a>

    @else

        <span class="text-slate-400 text-sm">
            Belum tersedia
        </span>

    @endif

</td>

    </tr>

    @empty

    <tr>
        <td colspan="7" class="text-center py-10 text-slate-400">
            Belum ada transaksi
        </td>
    </tr>

    @endforelse

</tbody>
                </table>
            </div>
        </div>
    </main>
@endsection