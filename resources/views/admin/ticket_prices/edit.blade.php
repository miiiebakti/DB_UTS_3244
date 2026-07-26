@extends('layouts.admin')

@section('content')

<main class="flex-1 p-10 overflow-y-auto">

    <div class="mb-10">

        <a href="{{ route('admin.ticket-prices.index') }}"
            class="text-indigo-600 font-bold">

            ← Kembali

        </a>

        <h1 class="text-3xl font-black mt-5">
            Edit Harga Tiket
        </h1>

        <p class="text-slate-500 mt-2">
            Perbarui informasi harga tiket.
        </p>

    </div>


    @if($errors->any())

        <div class="mb-6 bg-red-100 border border-red-300 text-red-700 px-5 py-4 rounded-xl">

            @foreach($errors->all() as $error)

                <div>
                    {{ $error }}
                </div>

            @endforeach

        </div>

    @endif


    <div class="bg-white rounded-3xl border border-slate-200 p-8 max-w-3xl">

        <form
            action="{{ route('admin.ticket-prices.update', $ticketPrice) }}"
            method="POST"
            class="space-y-6">

            @csrf

            @method('PUT')


            <div>

                <label class="block font-bold mb-2">
                    Event
                </label>

                <select
                    name="event_id"
                    required
                    class="w-full px-5 py-4 border-2 border-slate-100 rounded-xl">

                    @foreach($events as $event)

                        <option
                            value="{{ $event->id }}"
                            {{ old('event_id', $ticketPrice->event_id) == $event->id ? 'selected' : '' }}>

                            {{ $event->title }}

                        </option>

                    @endforeach

                </select>

            </div>


            <div>

                <label class="block font-bold mb-2">
                    Nama Tahap
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $ticketPrice->name) }}"
                    required
                    class="w-full px-5 py-4 border-2 border-slate-100 rounded-xl">

            </div>


            <div>

                <label class="block font-bold mb-2">
                    Harga Tiket
                </label>

                <input
                    type="number"
                    name="price"
                    value="{{ old('price', $ticketPrice->price) }}"
                    min="0"
                    required
                    class="w-full px-5 py-4 border-2 border-slate-100 rounded-xl">

            </div>


            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>

                    <label class="block font-bold mb-2">
                        Mulai Berlaku
                    </label>

                    <input
                        type="date"
                        name="start_date"
                        value="{{ old('start_date', $ticketPrice->start_date->format('Y-m-d')) }}"
                        required
                        class="w-full px-5 py-4 border-2 border-slate-100 rounded-xl">

                </div>


                <div>

                    <label class="block font-bold mb-2">
                        Berakhir
                    </label>

                    <input
                        type="date"
                        name="end_date"
                        value="{{ old('end_date', $ticketPrice->end_date?->format('Y-m-d')) }}"
                        class="w-full px-5 py-4 border-2 border-slate-100 rounded-xl">

                </div>

            </div>


            <div>

                <label class="block font-bold mb-2">
                    Kuota Tahap
                </label>

                <input
                    type="number"
                    name="quota"
                    value="{{ old('quota', $ticketPrice->quota) }}"
                    min="1"
                    class="w-full px-5 py-4 border-2 border-slate-100 rounded-xl">

            </div>


            <label class="flex items-center gap-3">

                <input
                    type="checkbox"
                    name="is_active"
                    value="1"
                    {{ old('is_active', $ticketPrice->is_active) ? 'checked' : '' }}
                    class="w-5 h-5">

                <span class="font-bold">
                    Harga Aktif
                </span>

            </label>


            <button
                type="submit"
                class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-black">

                Simpan Perubahan

            </button>

        </form>

    </div>

</main>

@endsection