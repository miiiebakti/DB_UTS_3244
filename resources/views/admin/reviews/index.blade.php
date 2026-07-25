@extends('layouts.admin')

@section('content')

<main class="flex-1 p-10 overflow-y-auto">

    <div class="mb-10">

        <h1 class="text-3xl font-black">
            Review Pengunjung
        </h1>

        <p class="text-slate-500 font-medium mt-2">
            Lihat ulasan dan penilaian dari pengunjung event.
        </p>

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

                    <th class="px-6 py-4 text-left font-bold">
                        Event
                    </th>

                    <th class="px-6 py-4 text-left font-bold">
                        Pengunjung
                    </th>

                    <th class="px-6 py-4 text-center font-bold">
                        Rating
                    </th>

                    <th class="px-6 py-4 text-left font-bold">
                        Ulasan
                    </th>

                    <th class="px-6 py-4 text-left font-bold">
                        Tanggal
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse($reviews as $review)

                    <tr class="border-t hover:bg-slate-50">

                        <td class="px-6 py-4 font-bold">
                            {{ $review->event->title ?? '-' }}
                        </td>


                        <td class="px-6 py-4">

                            <div class="font-semibold">
                                {{ $review->name ?? $review->user->name ?? 'Pengunjung' }}
                            </div>

                            <div class="text-sm text-slate-500">
                                {{ $review->email ?? $review->user->email ?? '-' }}
                            </div>

                        </td>


                        <td class="px-6 py-4 text-center">

                            <span class="text-yellow-500 text-lg">
                                {{ str_repeat('⭐', $review->rating) }}
                            </span>

                            <div class="text-sm text-slate-500">
                                {{ $review->rating }}/5
                            </div>

                        </td>


                        <td class="px-6 py-4 max-w-md">

                            {{ $review->review }}

                        </td>


                        <td class="px-6 py-4 text-slate-500">

                            {{ $review->created_at->format('d M Y') }}

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5"
                            class="px-6 py-10 text-center text-slate-500">

                            Belum ada review untuk event Anda.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</main>

@endsection