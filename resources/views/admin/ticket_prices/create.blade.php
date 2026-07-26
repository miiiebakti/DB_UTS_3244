@extends('layouts.admin')

@section('content')

<main class="flex-1 bg-slate-50 p-10 overflow-y-auto">

    <div class="max-w-4xl mx-auto">

        <!-- Header -->
        <div class="mb-8">

            <a href="{{ route('admin.ticket-prices.index') }}"
                class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-700 font-semibold">
                ← Kembali
            </a>

            <h1 class="text-3xl font-black mt-5">
                Tambah Harga Tiket
            </h1>

            <p class="text-slate-500 mt-2">
                Tambahkan tahap harga tiket untuk event.
            </p>

        </div>

        <!-- Error -->
        @if($errors->any())

            <div class="mb-6 bg-red-50 border border-red-200 text-red-600 rounded-2xl p-5">

                <ul class="list-disc list-inside space-y-1">

                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

            </div>

        @endif

        <!-- Card -->
        <div class="bg-white rounded-3xl shadow-lg border border-slate-200 p-8">

            <form action="{{ route('admin.ticket-prices.store') }}"
                method="POST"
                class="space-y-6">

                @csrf

                <!-- Event -->
                <div>

                    <label class="block font-semibold text-slate-700 mb-2">
                        Event
                    </label>

                    <select
                        name="event_id"
                        required
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-indigo-500 focus:ring-indigo-500">

                        <option value="">
                            Pilih Event
                        </option>

                        @foreach($events as $event)

                            <option value="{{ $event->id }}"
                                {{ old('event_id') == $event->id ? 'selected' : '' }}>

                                {{ $event->title }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <!-- Nama Tahap -->
                <div>

                    <label class="block font-semibold text-slate-700 mb-2">
                        Nama Tahap
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Contoh : Early Bird"
                        required
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-indigo-500 focus:ring-indigo-500">

                </div>

                <!-- Harga -->
                <div>

                    <label class="block font-semibold text-slate-700 mb-2">
                        Harga Tiket
                    </label>

                    <input
                        type="number"
                        name="price"
                        value="{{ old('price') }}"
                        min="0"
                        required
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-indigo-500 focus:ring-indigo-500">

                </div>

                <!-- Tanggal -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>

                        <label class="block font-semibold text-slate-700 mb-2">
                            Mulai Berlaku
                        </label>

                        <input
                            type="date"
                            name="start_date"
                            value="{{ old('start_date') }}"
                            required
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-indigo-500 focus:ring-indigo-500">

                    </div>

                    <div>

                        <label class="block font-semibold text-slate-700 mb-2">
                            Berakhir
                        </label>

                        <input
                            type="date"
                            name="end_date"
                            value="{{ old('end_date') }}"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-indigo-500 focus:ring-indigo-500">

                    </div>

                </div>

                <!-- Kuota -->
                <div>

                    <label class="block font-semibold text-slate-700 mb-2">
                        Kuota Tahap
                    </label>

                    <input
                        type="number"
                        name="quota"
                        value="{{ old('quota') }}"
                        min="1"
                        placeholder="Kosongkan jika tidak dibatasi"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-indigo-500 focus:ring-indigo-500">

                </div>

                <!-- Status -->
                <div>

                    <label class="flex items-center gap-3">

                        <input
                            type="checkbox"
                            name="is_active"
                            value="1"
                            checked
                            class="w-5 h-5 text-indigo-600 rounded">

                        <span class="font-semibold text-slate-700">
                            Harga Aktif
                        </span>

                    </label>

                </div>

                <!-- Button -->
                <div class="flex justify-end gap-4 pt-6 border-t border-slate-200">

                    <a href="{{ route('admin.ticket-prices.index') }}"
                        class="px-6 py-3 rounded-xl border border-slate-300 font-semibold hover:bg-slate-100 transition">

                        Batal

                    </a>

                    <button
                        type="submit"
                        class="px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold transition">

                        Simpan Harga

                    </button>

                </div>

            </form>

        </div>

    </div>

</main>

@endsection