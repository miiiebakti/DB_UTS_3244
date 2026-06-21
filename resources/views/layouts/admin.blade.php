<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - AmikomEventHub</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-900 flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-indigo-900 text-indigo-100 flex flex-col p-6 space-y-8 sticky top-0 h-screen">

        <!-- LOGO -->
        <div class="flex items-center gap-3">
            <div
                class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-indigo-900 font-bold text-xl">
                AH
            </div>

            <span class="text-xl font-bold text-white tracking-tight">
                AmikomEventHub
            </span>
        </div>

        <!-- MENU -->
        <nav class="flex-1 space-y-2">

            <p class="text-[10px] font-bold uppercase tracking-widest text-indigo-400 mb-4 px-2">
                Main Menu
            </p>

            <!-- DASHBOARD -->
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition
                {{ Request::is('admin/dashboard') ? 'bg-indigo-700 text-white' : 'hover:bg-indigo-800' }}">

                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4
                        16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0
                        01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0
                        01-2 2h-2a2 2 0 01-2-2v-2z">
                    </path>

                </svg>

                Dashboard
            </a>

            <!-- KATEGORI -->
            <a href="{{ route('categories.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition
                {{ Request::is('admin/categories*') ? 'bg-indigo-700 text-white' : 'hover:bg-indigo-800' }}">

                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">

                    <path stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2"
                        d="M3 7h18M3 12h18M3 17h18">
                    </path>

                </svg>

                Kategori
            </a>

            <!-- PARTNER -->
            <a href="{{ route('partners.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition
                {{ Request::is('admin/partners*') ? 'bg-indigo-700 text-white' : 'hover:bg-indigo-800' }}">

                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">

                    <path stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2"
                        d="M17 20h5V4H2v16h5m10 0v-6a2 2 0 00-2-2H9a2 2 0
                        00-2 2v6m10 0H7">
                    </path>

                </svg>

                Partner
            </a>

            <!-- EVENT -->
            <a href="{{ route('admin.events') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition
                {{ Request::is('admin/events*') ? 'bg-indigo-700 text-white' : 'hover:bg-indigo-800' }}">

                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">

                    <path stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0
                        00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>

                </svg>

                Kelola Event
            </a>

            <!-- TRANSAKSI -->
            <a href="{{ route('transactions.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition
                {{ Request::is('admin/transactions*') ? 'bg-indigo-700 text-white' : 'hover:bg-indigo-800' }}">

                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">

                    <path stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0
                        002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012
                        2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0
                        012-2h2a2 2 0 012 2v14a2 2 0 01-2
                        2h-2a2 2 0 01-2-2z">
                    </path>

                </svg>

                Laporan Transaksi
            </a>

        </nav>

             <!-- FOOTER -->
        <div class="pt-6 border-t border-indigo-800">

            <a href="/"
                class="flex items-center gap-3 px-4 py-3 text-indigo-300 hover:text-white transition font-medium">

                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">

                    <path stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6
                        4v1a3 3 0 01-3 3H6a3 3 0
                        01-3-3V7a3 3 0 013-3h4a3
                        3 0 013 3v1">
                    </path>

                </svg>

                Keluar
            </a>

        </div>

    </aside>

    @yield('content')

</body>

</html>