@extends('layouts.admin')

@section('content')

<main class="flex-1 p-10 overflow-y-auto">

    <div class="mb-10">

        <a href="{{ route('admin.ticket-types.index', $event->id) }}"
            class="text-indigo-600 font-bold">
            ← Kembali
        </a>

        <h1 class="text-3xl font-black mt-5">
            Edit Kategori Tiket
        </h1>

        <p class="text-slate-500 mt-2">
            Event: {{ $event->title }}
        </p>

    </div>


    @if($errors->any())

        <div class="mb-6 bg-red-100 border border-red-300 text-red-700 px-5 py-4 rounded-2xl">

            <ul class="list-disc ml-5">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    <div class="bg-white rounded-3xl border p-8 max-w-3xl">

        <form
            action="{{ route('admin.ticket-types.update', [$event->id, $ticketType->id]) }}"
            method="POST"
            class="space-y-6">

            @csrf
            @method('PUT')


            <div>

                <label class="block font-bold mb-2">
                    Nama Kategori Tiket
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $ticketType->name) }}"
                    required
                    class="w-full px-5 py-4 border-2 border-slate-200 rounded-xl">

            </div>


            <div>

                <label class="block font-bold mb-2">
                    Harga Tiket
                </label>

                <input
                    type="number"
                    name="price"
                    value="{{ old('price', $ticketType->price) }}"
                    min="0"
                    required
                    class="w-full px-5 py-4 border-2 border-slate-200 rounded-xl">

            </div>


            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>

                    <label class="block font-bold mb-2">
                        Tanggal Mulai
                    </label>

                    <input
                        type="date"
                        name="start_date"
                        value="{{ old('start_date', $ticketType->start_date->format('Y-m-d')) }}"
                        required
                        class="w-full px-5 py-4 border-2 border-slate-200 rounded-xl">

                </div>


                <div>

                    <label class="block font-bold mb-2">
                        Tanggal Berakhir
                    </label>

                    <input
                        type="date"
                        name="end_date"
                        value="{{ old('end_date', $ticketType->end_date->format('Y-m-d')) }}"
                        required
                        class="w-full px-5 py-4 border-2 border-slate-200 rounded-xl">

                </div>

            </div>


            <div>

                <label class="block font-bold mb-2">
                    Stok Tiket
                </label>

                <input
                    type="number"
                    name="stock"
                    value="{{ old('stock', $ticketType->stock) }}"
                    min="0"
                    required
                    class="w-full px-5 py-4 border-2 border-slate-200 rounded-xl">

            </div>


            <button
                type="submit"
                class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-black">

                Simpan Perubahan

            </button>

        </form>

    </div>

</main>

@endsection