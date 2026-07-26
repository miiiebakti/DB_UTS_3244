@extends('layouts.admin')

@section('content')

<main class="flex-1 p-10 overflow-y-auto">

    <div class="w-full">

        <!-- HEADER -->
        <div class="flex items-center justify-between mb-10">

            <div>
                <h1 class="text-3xl font-black">
                    Voucher
                </h1>

                <p class="text-slate-500 font-medium mt-2">
                    Kelola kode voucher dan diskon untuk pengunjung.
                </p>
            </div>

            <a href="{{ route('admin.vouchers.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-bold transition">

                + Tambah Voucher

            </a>

        </div>


        <!-- SUCCESS MESSAGE -->
        @if(session('success'))

            <div class="mb-6 bg-green-100 border border-green-300 text-green-700 px-5 py-4 rounded-xl">
                {{ session('success') }}
            </div>

        @endif


        <!-- TABLE -->
        <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden">

            <table class="w-full">

                <thead class="bg-slate-100">

                    <tr>

                        <th class="px-6 py-4 text-left font-bold">
                            Kode Voucher
                        </th>

                        <th class="px-6 py-4 text-left font-bold">
                            Diskon
                        </th>

                        <th class="px-6 py-4 text-left font-bold">
                            Berlaku
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

                    @forelse($vouchers as $voucher)

                        <tr class="border-t hover:bg-slate-50">

                            <!-- KODE -->
                            <td class="px-6 py-5 font-bold">

                                {{ $voucher->code }}

                            </td>


                            <!-- DISKON -->
                            <td class="px-6 py-5">

                                @if($voucher->type === 'percent')

                                    {{ number_format($voucher->value, 2) }}%

                                @else

                                    Rp {{ number_format($voucher->value, 0, ',', '.') }}

                                @endif

                            </td>


                            <!-- BERLAKU -->
                            <td class="px-6 py-5 text-slate-500">

                                @if($voucher->start_date && $voucher->end_date)

                                    {{ \Carbon\Carbon::parse($voucher->start_date)->format('d M Y') }}

                                    -

                                    {{ \Carbon\Carbon::parse($voucher->end_date)->format('d M Y') }}

                                @elseif($voucher->start_date)

                                    Mulai
                                    {{ \Carbon\Carbon::parse($voucher->start_date)->format('d M Y') }}

                                @elseif($voucher->end_date)

                                    Sampai
                                    {{ \Carbon\Carbon::parse($voucher->end_date)->format('d M Y') }}

                                @else

                                    Tidak dibatasi

                                @endif

                            </td>


                            <!-- KUOTA -->
                            <td class="px-6 py-5">

                                {{ $voucher->quota ?? 'Tidak terbatas' }}

                            </td>


                            <!-- STATUS -->
                            <td class="px-6 py-5">

                                @if($voucher->is_active)

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

                                    <a href="{{ route('admin.vouchers.edit', $voucher->id) }}"
                                        class="px-4 py-3 rounded-xl bg-indigo-50 text-indigo-600 hover:bg-indigo-100 font-medium transition">

                                        Edit

                                    </a>


                                    <form action="{{ route('admin.vouchers.destroy', $voucher->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus voucher ini?')">

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

                            <td colspan="6"
                                class="px-6 py-12 text-center text-slate-500">

                                Belum ada voucher.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</main>

@endsection