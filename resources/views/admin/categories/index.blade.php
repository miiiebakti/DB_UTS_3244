@extends('layouts.admin')

@section('content')

<main class="flex-1 p-10 overflow-y-auto">
    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5 mb-8">
        <div>
            <h1 class="text-3xl font-black">
                Manajemen Kategori
            </h1>

            <p class="text-slate-500 font-medium">
                Kelola data kategori event AmikomEventHub
            </p>
        </div>

        <div class="flex flex-col md:flex-row gap-3">
            <!-- SEARCH -->
            <form
                action="{{ route('categories.index') }}"
                method="GET"
                class="flex gap-2">

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari kategori..."
                    class="px-4 py-3 border border-slate-300 rounded-2xl outline-none focus:ring-2 focus:ring-indigo-500">

                <button
                    type="submit"
                    class="px-5 py-3 bg-slate-800 text-white rounded-2xl font-bold hover:bg-slate-900 transition">
                    Cari
                </button>
            </form>

            <!-- BUTTON TAMBAH -->
            <a
                href="{{ route('categories.create') }}"
                class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 transition text-center">
                + Tambah Kategori
            </a>
        </div>
    </div>

    <!-- SUCCESS MESSAGE -->
    @if(session('success'))

        <div class="mb-6 bg-green-100 border border-green-300 text-green-700 px-5 py-4 rounded-2xl font-medium">
            {{ session('success') }}
        </div>

    @endif

    <!-- TABLE -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <!-- TABLE HEAD -->
                <thead class="bg-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-black text-slate-700">
                            ID
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-black text-slate-700">
                            Nama Kategori
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-black text-slate-700">
                            Deskripsi
                        </th>

                        <th class="px-6 py-4 text-center text-sm font-black text-slate-700">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <!-- TABLE BODY -->
                <tbody>

                    @forelse($categories as $category)

                        <tr class="border-t border-slate-200 hover:bg-slate-50 transition">

                            <!-- ID -->
                            <td class="px-6 py-4 text-sm text-slate-700">
                                {{ $category->id }}
                            </td>

                            <!-- NAME -->
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-800">
                                    {{ $category->name }}
                                </div>
                            </td>

                            <!-- DESCRIPTION -->
                            <td class="px-6 py-4 text-sm text-slate-600">
                                {{ $category->description }}
                            </td>

                            <!-- ACTION -->
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
                                    <!-- EDIT -->
                                    <a
                                        href="{{ route('categories.edit', $category->id) }}"
                                        class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl">
                                        Edit
                                    </a>

                                    <!-- DELETE -->
                                    <form
                                        action="{{ route('categories.destroy', $category->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            onclick="return confirm('Yakin ingin menghapus kategori ini?')"
                                            class="p-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                                Data kategori belum tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>
@endsection