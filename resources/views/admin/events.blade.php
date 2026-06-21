@extends('layouts.admin')

@section('content')
  
    <main class="flex-1 p-10 overflow-y-auto">
        <header class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-3xl font-black">Kelola Event</h1>
                <p class="text-slate-500 font-medium">Buat dan atur acara seru Anda di sini.</p>
            </div>
           <a href="/admin/events/create"
    class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 active:scale-95 transition">
    + Tambah Event Baru
</a>
        </header>

        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-8 py-6 bg-slate-50/50 border-b flex gap-4">
                <input type="text" placeholder="Cari nama event..."
                    class="flex-1 px-5 py-3 rounded-xl border-slate-200 border bg-white focus:ring-2 focus:ring-indigo-500 outline-none transition">
                <select class="px-5 py-3 rounded-xl border-slate-200 border bg-white outline-none">
                    <option>Semua Kategori</option>
                    <option>Musik</option>
                    <option>Workshop</option>
                </select>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                        <tr>
                            <th class="px-8 py-4 w-16">No</th>
                            <th class="px-8 py-4">Poster</th>
                            <th class="px-8 py-4">Event</th>
                            <th class="px-8 py-4">Harga / Stok</th>
                            <th class="px-8 py-4">Aksi</th>
                        </tr>
                    </thead>
                   <tbody class="divide-y border-t">
    @foreach ($events as $event)
    <tr class="hover:bg-slate-50/50 transition">
        <td class="px-8 py-6 font-bold text-slate-400">
            {{ $loop->iteration }}
        </td>

        <td class="px-8 py-6">
           <img src="{{ ($event->poster_path &&
                Storage::disk('public')->exists($event->poster_path))
                ? asset('storage/'.$event->poster_path)
                : 'https://placehold.co/200x600' }}"
                class="w-16 h-20 rounded-xl object-cover">
        </td>

        <td class="px-8 py-6">
            <p class="font-black text-slate-800">
                {{ $event->title }}
            </p>
            <p class="text-xs text-slate-400">
                {{ $event->date }}
            </p>
        </td>

        <td class="px-8 py-6">
            <p class="font-bold text-indigo-600">
                Rp {{ number_format($event->price) }}
            </p>
            <p class="text-xs text-slate-400">
                Stok: {{ $event->stock }}
            </p>
        </td>

        <td class="px-8 py-6">
            <div class="flex gap-2">

                <a href="/admin/events/{{ $event->id }}/edit"
                    class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl">
                    Edit
                </a>

              <form action="/admin/events/{{ $event->id }}" method="POST"
      onsubmit="return confirm('Yakin mau hapus event ini?')">
    @csrf
    @method('DELETE')

    <button type="submit"
        class="p-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition">
        Hapus
    </button>
</form>

            </div>
        </td>
    </tr>
    @endforeach
</tbody>
                </table>
            </div>
        </div>
    </main>

@endsection