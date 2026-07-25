@extends('layouts.app')

@section('content')

<main class="max-w-6xl mx-auto px-6 py-12">

    {{-- HEADER ORGANIZER --}}
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 mb-10">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">

            <div>
                <p class="text-indigo-600 font-semibold mb-2">
                    Verified Organizer
                </p>

                <h1 class="text-4xl font-black text-slate-800">
                    {{ $user->name }}
                </h1>

                <p class="text-slate-500 mt-2">
                    {{ $user->email }}
                </p>
            </div>

            <div class="bg-indigo-50 rounded-2xl px-8 py-5 text-center">

                <div class="text-3xl font-black text-indigo-600">
                    ⭐ {{ $averageRating }}/5
                </div>

                <p class="text-sm text-slate-500 mt-1">
                    {{ $totalReview }} Ulasan
                </p>

            </div>

        </div>

    </div>


    {{-- RATING & REVIEW --}}
    <div class="mb-10">

        <h2 class="text-2xl font-bold text-slate-800 mb-2">
            Rating & Ulasan
        </h2>

        <p class="text-slate-500 mb-6">
            Pengalaman peserta dari event yang diselenggarakan.
        </p>


        @forelse($reviews as $review)

            <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-6 mb-4">

                <div class="flex justify-between items-start gap-4">

                    <div>

                        <h3 class="font-bold text-slate-800">
                            {{ $review->name ?? 'Pengunjung' }}
                        </h3>

                        <p class="text-sm text-slate-400 mt-1">
                            {{ $review->created_at->format('d M Y') }}
                        </p>

                    </div>

                    <div class="text-yellow-500">
                        {{ str_repeat('⭐', $review->rating) }}
                    </div>

                </div>

                <p class="text-slate-600 mt-4">
                    {{ $review->review }}
                </p>

            </div>

        @empty

            <div class="bg-slate-50 rounded-2xl p-8 text-center">

                <p class="text-slate-500">
                    Belum ada ulasan dari peserta.
                </p>

            </div>

        @endforelse

    </div>


    {{-- EVENT ORGANIZER --}}
    <div>

        <h2 class="text-2xl font-bold text-slate-800 mb-2">
            Event yang Diselenggarakan
        </h2>

        <p class="text-slate-500 mb-6">
            Lihat event yang pernah diselenggarakan oleh {{ $user->name }}.
        </p>


        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            @forelse($events as $event)

                <a
                    href="{{ route('events.show', $event->id) }}"
                    class="bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition">

                    <div class="aspect-video bg-slate-100">

                        <img
                            src="{{ ($event->poster_path && Storage::disk('public')->exists($event->poster_path))
                                ? asset('storage/'.$event->poster_path)
                                : 'https://placehold.co/600x400' }}"
                            alt="{{ $event->title }}"
                            class="w-full h-full object-cover">

                    </div>

                    <div class="p-5">

                        <h3 class="font-bold text-lg text-slate-800">
                            {{ $event->title }}
                        </h3>

                        <p class="text-sm text-slate-500 mt-2">
                            {{ \Carbon\Carbon::parse($event->date)->format('d M Y H:i') }}
                        </p>

                    </div>

                </a>

            @empty

                <div class="col-span-full bg-slate-50 rounded-2xl p-8 text-center">

                    <p class="text-slate-500">
                        Belum ada event.
                    </p>

                </div>

            @endforelse

        </div>

    </div>

</main>

@endsection