@extends('layouts.admin')

@section('content')

<main class="flex-1 p-10 overflow-y-auto">

    <div class="max-w-5xl mx-auto">

        <div class="mb-10">

            <a href="{{ route('admin.vouchers.index') }}"
                class="text-indigo-600 font-bold hover:text-indigo-800">

                ← Kembali

            </a>

            <h1 class="text-3xl font-black mt-5">
                Tambah Voucher
            </h1>

            <p class="text-slate-500 mt-2">
                Buat kode voucher baru untuk pengunjung.
            </p>

        </div>

        @if($errors->any())

            <div class="mb-6 bg-red-100 border border-red-300 text-red-700 px-5 py-4 rounded-xl">

                @foreach($errors->all() as $error)

                    <div>{{ $error }}</div>

                @endforeach

            </div>

        @endif

        <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-sm">

            <form action="{{ route('admin.vouchers.store') }}"
                method="POST"
                class="space-y-7">

                @csrf

                <div>

                    <label class="block font-bold mb-2">
                        Kode Voucher
                    </label>

                    <input
                        type="text"
                        name="code"
                        value="{{ old('code') }}"
                        placeholder="CONTOH: MAHASISWA50"
                        class="w-full px-5 py-4 border-2 border-slate-100 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none uppercase"
                        required>

                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>

                        <label class="block font-bold mb-2">
                            Jenis Diskon
                        </label>

                        <select
                            name="type"
                            class="w-full px-5 py-4 border-2 border-slate-100 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none"
                            required>

                            <option value="percent"
                                {{ old('type') == 'percent' ? 'selected' : '' }}>
                                Persentase (%)
                            </option>

                            <option value="fixed"
                                {{ old('type') == 'fixed' ? 'selected' : '' }}>
                                Potongan Nominal (Rp)
                            </option>

                        </select>

                    </div>

                    <div>

                        <label class="block font-bold mb-2">
                            Nilai Diskon
                        </label>

                        <input
                            type="number"
                            name="value"
                            value="{{ old('value') }}"
                            placeholder="Contoh: 50"
                            min="0"
                            step="0.01"
                            class="w-full px-5 py-4 border-2 border-slate-100 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none"
                            required>

                    </div>

                </div>

                <p class="text-sm text-slate-400 -mt-4">
                    Jika persen isi 50 untuk diskon 50%. Jika nominal isi jumlah potongannya.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>

                        <label class="block font-bold mb-2">
                            Mulai Berlaku
                        </label>

                        <input
                            type="date"
                            name="start_date"
                            value="{{ old('start_date') }}"
                            class="w-full px-5 py-4 border-2 border-slate-100 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none">

                    </div>

                    <div>

                        <label class="block font-bold mb-2">
                            Berakhir
                        </label>

                        <input
                            type="date"
                            name="end_date"
                            value="{{ old('end_date') }}"
                            class="w-full px-5 py-4 border-2 border-slate-100 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none">

                    </div>

                </div>

                <div>

                    <label class="block font-bold mb-2">
                        Kuota Voucher
                    </label>

                    <input
                        type="number"
                        name="quota"
                        value="{{ old('quota') }}"
                        min="1"
                        placeholder="Kosongkan jika tidak dibatasi"
                        class="w-full px-5 py-4 border-2 border-slate-100 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none">

                </div>

                <label class="flex items-center gap-3 cursor-pointer">

                    <input
                        type="checkbox"
                        name="is_active"
                        value="1"
                        {{ old('is_active', 1) ? 'checked' : '' }}
                        class="w-5 h-5">

                    <span class="font-bold">
                        Voucher Aktif
                    </span>

                </label>

                <div class="pt-4">

                    <button
                        type="submit"
                        class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-black transition">

                        Simpan Voucher

                    </button>

                </div>

            </form>

        </div>

    </div>

</main>

@endsection