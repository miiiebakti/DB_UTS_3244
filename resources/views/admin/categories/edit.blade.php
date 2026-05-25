@extends('layouts.admin')

@section('content')
<main class="flex-1 p-10 overflow-y-auto">
    <div class="max-w-3xl mx-auto">
        <!-- TITLE -->
        <div class="mb-8">
            <h1 class="text-3xl font-black mb-2">
                Edit Kategori
            </h1>
            <p class="text-slate-500">
                Perbarui data kategori event.
            </p>
        </div>

        <!-- ERROR -->
        @if ($errors->any())
            <div class="mb-6 bg-red-100 border border-red-300 text-red-700 px-5 py-4 rounded-2xl">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>

        @endif

        <!-- CARD -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8">
            <form action="{{ route('categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')
                <!-- NAME -->
                <div class="mb-6">
                    <label class="block mb-2 font-bold text-slate-700">
                        Nama Kategori
                    </label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', $category->name) }}"
                        placeholder="Masukkan nama kategori"
                        class="w-full px-5 py-3 border border-slate-300 rounded-2xl outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <!-- DESCRIPTION -->
                <div class="mb-6">
                    <label class="block mb-2 font-bold text-slate-700">
                        Deskripsi
                    </label>

                    <textarea
                        name="description"
                        rows="5"
                        placeholder="Masukkan deskripsi kategori"
                        class="w-full px-5 py-3 border border-slate-300 rounded-2xl outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description', $category->description) }}</textarea>

                </div>

                <!-- BUTTON -->
                <div class="flex gap-3">

                    <button
                        type="submit"
                        class="px-6 py-3 bg-yellow-500 text-white rounded-2xl font-bold hover:bg-yellow-600 transition">
                        Update
                    </button>

                    <a
                        href="{{ route('categories.index') }}"
                        class="px-6 py-3 bg-slate-200 text-slate-700 rounded-2xl font-bold hover:bg-slate-300 transition">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection