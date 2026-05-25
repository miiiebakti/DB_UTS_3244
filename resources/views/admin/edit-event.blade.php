@extends('layouts.admin')

@section('content')

<main class="flex-1 p-10 overflow-y-auto">
    <header class="mb-10">
        <h1 class="text-3xl font-black">Edit Event</h1>
        <p class="text-slate-500 font-medium">Perbarui detail event Anda.</p>
    </header>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8 max-w-4xl">
        <form action="/admin/events/{{ $event->id }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block mb-2 font-bold text-slate-700">Category ID</label>
                <input type="number" name="category_id" value="{{ $event->category_id }}"
                    class="w-full px-5 py-4 rounded-2xl border border-slate-200">
            </div>

            <div>
                <label class="block mb-2 font-bold text-slate-700">Title</label>
                <input type="text" name="title" value="{{ $event->title }}"
                    class="w-full px-5 py-4 rounded-2xl border border-slate-200">
            </div>

            <div>
                <label class="block mb-2 font-bold text-slate-700">Description</label>
                <textarea name="description" rows="4"
                    class="w-full px-5 py-4 rounded-2xl border border-slate-200">{{ $event->description }}</textarea>
            </div>

            <div>
                <label class="block mb-2 font-bold text-slate-700">Date</label>
                <input type="datetime-local" name="date" value="{{ $event->date }}"
                    class="w-full px-5 py-4 rounded-2xl border border-slate-200">
            </div>

            <div>
                <label class="block mb-2 font-bold text-slate-700">Location</label>
                <input type="text" name="location" value="{{ $event->location }}"
                    class="w-full px-5 py-4 rounded-2xl border border-slate-200">
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block mb-2 font-bold text-slate-700">Price</label>
                    <input type="number" name="price" value="{{ $event->price }}"
                        class="w-full px-5 py-4 rounded-2xl border border-slate-200">
                </div>

                <div>
                    <label class="block mb-2 font-bold text-slate-700">Stock</label>
                    <input type="number" name="stock" value="{{ $event->stock }}"
                        class="w-full px-5 py-4 rounded-2xl border border-slate-200">
                </div>
            </div>

            <div>
                <label class="block mb-2 font-bold text-slate-700">Poster Path</label>
                <input type="text" name="poster_path" value="{{ $event->poster_path }}"
                    class="w-full px-5 py-4 rounded-2xl border border-slate-200">
            </div>

            <div class="flex gap-4 pt-4">
                <button type="submit"
                    class="px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition">
                    Update Event
                </button>

                <a href="/admin/events"
                    class="px-8 py-4 bg-slate-100 text-slate-700 rounded-2xl font-bold hover:bg-slate-200 transition">
                    Batal
                </a>
            </div>

        </form>
    </div>
</main>

@endsection