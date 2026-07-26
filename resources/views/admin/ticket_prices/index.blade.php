@extends('layouts.admin')

@section('content')

<main class="flex-1 p-10 overflow-y-auto">

    <div class="w-full">

        <!-- HEADER -->
        <div class="flex items-center justify-between mb-10">

            <div>
                <h1 class="text-3xl font-black">
                    Harga Tiket
                </h1>

                <p class="text-slate-500 font-medium mt-2">
                    Kelola harga tiket bertahap berdasarkan periode penjualan.
                </p>
            </div>

            <a href="{{ route('admin.ticket-prices.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-bold transition">

                + Tambah Harga

            </a>

        </div>


        <!-- SUCCESS -->
        @if(session('success'))

            <div class="mb-6 bg-green-100 border border-green-300 text-green-700 px-5 py-4 rounded-xl">
                {{ session('success') }}
            </div>

        @endif


        <!-- TABLE -->
        <div class="bg-white rounded-3xl border border-slate-200 overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-100">

                    <tr>

                        <th class="px-6 py-4 text-left font-bold">
                            Event
                        </th>

                        <th class="px-6 py-4 text-left font-bold">
                            Tahap
                        </th>

                        <th class="px-6 py-4 text-left font-bold">
                            Harga
                        </th>

                        <th class="px-6 py-4 text-left font-bold">
                            Periode
                        </th>

                        <th class="px-6 py-4 text-left font-bold">
                            Kuota
                        </th>

                        <th class="px-6 py-4 text-left font-bold">
                            Status
                        </th>

                        <th class="px-6 py-4 text-left font-bold">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($ticketPrices as $ticketPrice)

                        <tr class="border-t hover:bg-slate-50">

                            <!-- EVENT -->
                            <td class="px-6 py-5 font-bold">
                                {{ $ticketPrice->event->title ?? '-' }}
                            </td>

                            <!-- TAHAP -->
                            <td class="px-6 py-5">
                                {{ $ticketPrice->name }}
                            </td>

                            <!-- HARGA -->
                            <td class="px-6 py-5 font-bold text-indigo-600">
                                Rp {{ number_format($ticketPrice->price, 0, ',', '.') }}
                            </td>

                            <!-- PERIODE -->
                            <td class="px-6 py-5 text-slate-500">

                                {{ $ticketPrice->start_date->format('d M Y') }}

                                -

                                {{ $ticketPrice->end_date
                                    ? $ticketPrice->end_date->format('d M Y')
                                    : 'Seterusnya'
                                }}

                            </td>

                            <!-- KUOTA -->
                            <td class="px-6 py-5">

                                @if($ticketPrice->quota)

                                    {{ $ticketPrice->sold }} / {{ $ticketPrice->quota }}

                                @else

                                    Tidak terbatas

                                @endif

                            </td>

                            <!-- STATUS -->
                            <td class="px-6 py-5">

                                @if($ticketPrice->is_active)

                                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-600 font-semibold text-sm">
                                        Aktif
                                    </span>

                                @else

                                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-red-100 text-red-600 font-semibold text-sm">
                                        Nonaktif
                                    </span>

                                @endif

                            </td>

                            <!-- AKSI -->
                            <td class="px-6 py-5">

                                <div class="flex items-center gap-2">

                                    <a href="{{ route('admin.ticket-prices.edit', $ticketPrice->id) }}"
                                        class="px-4 py-3 rounded-xl bg-indigo-50 text-indigo-600 hover:bg-indigo-100 font-medium transition">

                                        Edit

                                    </a>

                                    <form action="{{ route('admin.ticket-prices.destroy', $ticketPrice->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus harga tiket ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="px-4 py-3 rounded-xl bg-red-50 text-red-600 hover:bg-red-100 font-medium transition">

                                            Hapus

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7"
                                class="px-6 py-12 text-center text-slate-500">

                                Belum ada harga tiket bertahap.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</main>

@endsection