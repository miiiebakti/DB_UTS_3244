@extends('layouts.admin')

@section('content')

<main class="flex-1 p-10 overflow-y-auto">

    <div class="flex items-center justify-between mb-10">

        <div>
            <h1 class="text-3xl font-black">
                Kategori Tiket
            </h1>

            <p class="text-slate-500 mt-2">
                Atur harga tiket berdasarkan periode penjualan.
            </p>

            <p class="text-sm text-indigo-600 font-bold mt-2">
                Event: {{ $event->title }}
            </p>
        </div>

        <a href="{{ route('admin.ticket-types.create', $event->id) }}"
            class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-bold">
            + Tambah Kategori
        </a>

    </div>


    @if(session('success'))

        <div class="mb-6 bg-green-100 border border-green-300 text-green-700 px-5 py-4 rounded-2xl">
            {{ session('success') }}
        </div>

    @endif


    <div class="bg-white rounded-3xl border overflow-hidden">

        <table class="w-full">

            <thead class="bg-slate-100">

                <tr>

                    <th class="px-6 py-4 text-left">
                        Nama Tiket
                    </th>

                    <th class="px-6 py-4 text-left">
                        Harga
                    </th>

                    <th class="px-6 py-4 text-left">
                        Mulai
                    </th>

                    <th class="px-6 py-4 text-left">
                        Berakhir
                    </th>

                    <th class="px-6 py-4 text-left">
                        Stok
                    </th>

                    <th class="px-6 py-4 text-center">
                        Aksi
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($ticketTypes as $ticket)

                    <tr class="border-t hover:bg-slate-50">

                        <td class="px-6 py-5 font-bold">
                            {{ $ticket->name }}
                        </td>

                        <td class="px-6 py-5 font-bold text-indigo-600">
                            Rp {{ number_format($ticket->price, 0, ',', '.') }}
                        </td>

                        <td class="px-6 py-5">
                            {{ $ticket->start_date->format('d M Y') }}
                        </td>

                        <td class="px-6 py-5">
                            {{ $ticket->end_date->format('d M Y') }}
                        </td>

                        <td class="px-6 py-5">
                            {{ $ticket->stock }}
                        </td>

                        <td class="px-6 py-5">

                            <div class="flex justify-center gap-2">

                                <a href="{{ route('admin.ticket-types.edit', [$event->id, $ticket->id]) }}"
                                    class="px-4 py-2 bg-yellow-100 text-yellow-700 rounded-lg font-bold">
                                    Edit
                                </a>

                                <form
                                    action="{{ route('admin.ticket-types.destroy', [$event->id, $ticket->id]) }}"
                                    method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        onclick="return confirm('Yakin ingin menghapus kategori tiket ini?')"
                                        class="px-4 py-2 bg-red-100 text-red-700 rounded-lg font-bold">
                                        Hapus
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="6"
                            class="px-6 py-10 text-center text-slate-500">

                            Belum ada kategori tiket.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</main>

@endsection