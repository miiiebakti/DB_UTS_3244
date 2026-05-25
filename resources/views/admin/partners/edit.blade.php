@extends('layouts.admin')

@section('content')

<main class="flex-1 p-10 overflow-y-auto">
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-3xl shadow border">
        <!-- TITLE -->
        <div class="mb-8">

            <h1 class="text-3xl font-black mb-2">
                Edit Partner
            </h1>

            <p class="text-slate-500">
                Perbarui data partner AmikomEventHub.
            </p>
        </div>

        <!-- ERROR -->
        @if ($errors->any())
            <div class="mb-6 bg-red-100 border border-red-300 text-red-600 px-5 py-4 rounded-2xl">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- FORM -->
        <form action="{{ route('partners.update', $partner->id) }}"
              method="POST"
              class="space-y-6">
            @csrf
            @method('PUT')

            <!-- NAME -->
            <div>
                <label class="block mb-2 font-bold text-slate-700">
                    Nama Partner
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $partner->name) }}"
                    class="w-full px-5 py-3 rounded-2xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>

            <!-- LOGO URL -->
            <div>
                <label class="block mb-2 font-bold text-slate-700">
                    Logo URL
                </label>

                <input
                    type="text"
                    name="logo_url"
                    value="{{ old('logo_url', $partner->logo_url) }}"
                    class="w-full px-5 py-3 rounded-2xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>

            <!-- PREVIEW -->
            <div>
                <label class="block mb-2 font-bold text-slate-700">
                    Preview Logo
                </label>

                <img
                    src="{{ $partner->logo_url }}"
                    class="w-32 h-32 object-contain rounded-2xl border p-3">
            </div>

            <!-- DESCRIPTION -->
            <div>
                <label class="block mb-2 font-bold text-slate-700">
                    Deskripsi
                </label>

                <textarea
                    name="description"
                    rows="4"
                    class="w-full px-5 py-3 rounded-2xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none">{{ old('description', $partner->description) }}</textarea>
            </div>

            <!-- WEBSITE -->
            <div>
                <label class="block mb-2 font-bold text-slate-700">
                    Website
                </label>

                <input
                    type="text"
                    name="website"
                    value="{{ old('website', $partner->website) }}"
                    class="w-full px-5 py-3 rounded-2xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>

            <!-- BUTTON -->
            <div class="flex gap-3">
                <button
                    type="submit"
                    class="px-6 py-3 bg-yellow-500 text-white rounded-2xl font-bold hover:bg-yellow-600 transition">
                    Update
                </button>

                <a href="{{ route('partners.index') }}"
                   class="px-6 py-3 bg-slate-200 text-slate-700 rounded-2xl font-bold hover:bg-slate-300 transition">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</main>
@endsection