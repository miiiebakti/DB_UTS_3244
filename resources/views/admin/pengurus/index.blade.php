@extends('layouts.admin')

@section('content')
<main class="flex-1 p-10 overflow-y-auto">

    <!-- HEADER -->
    <header class="flex justify-between items-center mb-10">
        <div>
            <h1 class="text-3xl font-black">
                Manajemen Pengurus
            </h1>
            <p class="text-slate-500 font-medium">
                Kelola data pengurus organisasi.
            </p>
        </div>

        <div class="flex gap-3">

            <!-- SEARCH -->
            <form action="{{ route('pengurus.index') }}"
                  method="GET"
                  class="flex gap-2">

                <input
                    type="text"
                    name="search"
                    placeholder="Cari pengurus..."
                    value="{{ request('search') }}"
                    class="px-4 py-2 rounded-xl border border-slate-300 outline-none focus:ring-2 focus:ring-indigo-500">

                <button
                    type="submit"
                    class="px-5 py-2 bg-slate-800 text-white rounded-xl font-bold">
                    Cari
                </button>

            </form>

            <!-- BUTTON -->
            <a href="{{ route('pengurus.create') }}"
               class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 transition">
                + Tambah Pengurus
            </a>

        </div>
    </header>

    <!-- SUCCESS -->
    @if(session('success'))
        <div class="mb-6 bg-green-100 border border-green-300 text-green-700 px-5 py-4 rounded-2xl">
            {{ session('success') }}
        </div>
    @endif

    <!-- TABLE -->
    <div class="bg-white rounded-3xl border overflow-hidden">

        <table class="w-full">

            <thead class="bg-slate-100">

                <tr>

                    <th class="px-6 py-4 text-left font-bold">ID</th>

                    <th class="px-6 py-4 text-left font-bold">
                        Jabatan
                    </th>

                    <th class="px-6 py-4 text-left font-bold">
                        Nama
                    </th>

                    <th class="px-6 py-4 text-left font-bold">
                        Deskripsi
                    </th>

                    <th class="px-6 py-4 text-left font-bold">
                        Salary
                    </th>

                    <th class="px-6 py-4 text-center font-bold">
                        Aksi
                    </th>

                </tr>

            </thead>

            <tbody>

            @forelse($penguruses as $pengurus)

                <tr class="border-t hover:bg-slate-50 transition">

                    <td class="px-6 py-4">
                        {{ $pengurus->id }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $pengurus->jabatan->name }}
                    </td>

                    <td class="px-6 py-4 font-bold">
                        {{ $pengurus->name }}
                    </td>

                    <td class="px-6 py-4 text-slate-500">
                        {{ $pengurus->description }}
                    </td>

                    <td class="px-6 py-4">
                        Rp {{ number_format($pengurus->salary,2,',','.') }}
                    </td>

                    <td class="px-6 py-4">

                        <div class="flex justify-center gap-2">

                            <a href="{{ route('pengurus.edit',$pengurus->id) }}"
                               class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl">
                                Edit
                            </a>

                            <form action="{{ route('pengurus.destroy',$pengurus->id) }}"
                                  method="POST">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    onclick="return confirm('Yakin hapus pengurus?')"
                                    class="p-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition">

                                    Hapus

                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="6"
                        class="px-6 py-8 text-center text-slate-500">

                        Data pengurus belum tersedia.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</main>
@endsection