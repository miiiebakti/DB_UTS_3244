@extends('layouts.admin')

@section('content')


    <!-- Main Content -->
    <main class="flex-1 p-10 overflow-y-auto">
        <!-- Header -->
        <header class="flex justify-between items-center mb-10">
            <div>
            @if(Auth::user()->role == 'superadmin')
                <h1 class="text-3xl font-black">Dashboard Super Admin</h1>
                <p class="text-slate-500 font-medium">
                    Selamat datang kembali, {{ Auth::user()->name }}!
                </p>
            @else
                <h1 class="text-3xl font-black">Dashboard Organizer</h1>
                <p class="text-slate-500 font-medium">
                    Selamat datang kembali, {{ Auth::user()->name }}!
                </p>
            @endif
            </div>
            <div class="flex items-center gap-4">
                <div class="text-right hidden md:block">
                    <p class="font-bold">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-slate-400">
                        {{ ucfirst(Auth::user()->role) }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-white rounded-2xl shadow-sm border flex items-center justify-center p-1">
                   <img src ="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=6366f1&color=fff"
                        class="rounded-xl">
                </div>
            </div>
        </header>

            <!-- Stats Grid -->
        @if(Auth::user()->role == 'superadmin')

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-6 mb-10">

        @else

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">

        @endif
         <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
             <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mb-4">
                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                         d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                     </path>
                 </svg>
             </div>
            @if(Auth::user()->role == 'superadmin')
                <p class="text-slate-400 text-sm font-bold uppercase mb-1">
                    Total Pendapatan
                </p>
            @else
                <p class="text-slate-400 text-sm font-bold uppercase mb-1">
                    Pendapatan Saya
                </p>
            @endif
             <h3 class="text-2xl font-black">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
         </div>
         <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
             <div class="w-12 h-12 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center mb-4">
                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                         d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z">
                     </path>
                 </svg>
             </div>
            @if(Auth::user()->role == 'superadmin')
                Total Tiket Terjual
            @else
                Tiket Event Saya
            @endif
             <h3 class="text-2xl font-black">{{ number_format($ticketsSold, 0, ',', '.') }}</h3>
         </div>
         <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
             <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center mb-4">
                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                         d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                 </svg>
             </div>

            @if(Auth::user()->role == 'superadmin')
                Event Aktif
            @else
                Event Saya
            @endif
             <h3 class="text-2xl font-black">{{ $activeEvents }} Event</h3>
         </div>
         <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
             <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center mb-4">
                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                         d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                 </svg>
             </div>
            @if(Auth::user()->role == 'superadmin')
                Pesanan Pending
            @else
                Pesanan Pending Saya
            @endif
             <h3 class="text-2xl font-black">{{ $pendingOrders }} Pesanan</h3>
         </div>

            @if(Auth::user()->role == 'superadmin')
           <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
            <div class="w-12 h-12 bg-violet-50 text-violet-600 rounded-2xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M17 20h5V4H2v16h5m10 0v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6m10 0H7M9 10h6M9 14h6">
                    </path>
                </svg>
            </div>

            <p class="text-slate-400 text-sm font-bold uppercase mb-1">
                Total Organizer
            </p>

            <h3 class="text-2xl font-black">
                {{ $totalOrganizers }}
            </h3>
        </div>
            @endif

        </div>


<!-- Grafik Dashboard -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">

    <!-- Grafik Pendapatan -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
        <h3 class="text-xl font-black mb-6">
            📈 Pendapatan per Bulan
        </h3>

        <canvas id="revenueChart"></canvas>
    </div>

    <!-- Grafik Event -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
        <h3 class="text-xl font-black mb-6">
            🎫 Event Dibuat per Bulan
        </h3>

        <canvas id="eventChart"></canvas>
    </div>

</div>

        <!-- Latest Sales Table -->
     <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
         <div class="p-8 border-b flex justify-between items-center">
             <h3 class="font-black text-xl">Transaksi Terakhir</h3>
             <a href="{{ route('transactions.index') }}" class="text-indigo-600 font-bold hover:underline">Lihat Semua</a>
         </div>
         <div class="overflow-x-auto">
             <table class="w-full text-left border-collapse">
                 <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                     <tr>
                         <th class="px-8 py-4 w-1/4">Tgl Transaksi</th>
                         <th class="px-8 py-4 w-1/4">Pembeli</th>
                         <th class="px-8 py-4 w-1/4">Event</th>
                         <th class="px-8 py-4 w-[10%]">Status</th>
                         <th class="px-8 py-4 text-right">Total</th>
                     </tr>
                 </thead>
                 <tbody class="divide-y border-t">
                     @forelse($recentTransactions as $trx)
                     <tr class="hover:bg-slate-50 transition">
                         <td class="px-8 py-6 text-sm text-slate-600 max-w-xs break-all">{{ $trx->created_at->format('d M y - H:i') }}<br><span class="text-xs text-slate-400">{{ $trx->order_id }}</span></td>
                         <td class="px-8 py-6">
                             <p class="font-bold uppercase tracking-wide text-sm truncate max-w-[150px]">{{ $trx->customer_name }}</p>
                             <p class="text-xs text-slate-400 truncate max-w-[150px]">{{ $trx->customer_email }}</p>
                         </td>
                         <td class="px-8 py-6 font-medium text-slate-600 max-w-xs truncate">{{ $trx->event->title ?? '-' }}</td>
                         <td class="px-8 py-6 whitespace-nowrap">
                             @if($trx->status === 'settlement' || $trx->status === 'success')
                                 <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-bold uppercase">Success</span>
                             @elseif($trx->status === 'pending')
                                 <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-lg text-xs font-bold uppercase">Pending</span>
                             @else
                                 <span class="px-3 py-1 bg-rose-100 text-rose-700 rounded-lg text-xs font-bold uppercase">{{ $trx->status }}</span>
                             @endif
                         </td>
                         <td class="px-8 py-6 font-black text-indigo-600 whitespace-nowrap text-right">Rp {{ number_format($trx->total_price, 0, ',', '.') }}</td>
                     </tr>
                     @empty
                     <tr>
                         <td colspan="5" class="px-8 py-10 text-center text-slate-500">Belum ada transaksi</td>
                     </tr>
                     @endforelse
                 </tbody>
             </table>
         </div>
     </div>

    </main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const revenueData = @json($monthlyRevenue);
const eventData = @json($monthlyEvents);

const months = [
    'Jan','Feb','Mar','Apr','Mei','Jun',
    'Jul','Agu','Sep','Okt','Nov','Des'
];

// =============================
// DATA PENDAPATAN
// =============================

let revenue = Array(12).fill(0);

revenueData.forEach(item => {
    revenue[item.month - 1] = item.total;
});

// =============================
// DATA EVENT
// =============================

let events = Array(12).fill(0);

eventData.forEach(item => {
    events[item.month - 1] = item.total;
});

// =============================
// GRAFIK PENDAPATAN
// =============================

new Chart(document.getElementById('revenueChart'), {

    type: 'bar',

    data: {

        labels: months,

        datasets: [{
            label: 'Pendapatan',
            data: revenue,
            backgroundColor: '#6366F1',
            borderRadius: 10,
            borderSkipped: false
        }]
    },

    options: {

        responsive: true,

        plugins: {

            legend: {
                display: false
            },

            tooltip: {

                callbacks: {

                    label: function(context){

                        return 'Rp ' + context.raw.toLocaleString('id-ID');

                    }

                }

            }

        },

        scales: {

            y: {

                ticks: {

                    callback:function(value){

                        return 'Rp ' + value.toLocaleString('id-ID');

                    }

                }

            }

        }

    }

});

// =============================
// GRAFIK EVENT
// =============================

new Chart(document.getElementById('eventChart'), {

    type:'line',

    data:{

        labels:months,

        datasets:[{

            label:'Jumlah Event',

            data:events,

            borderColor:'#6366F1',

            backgroundColor:'rgba(99,102,241,.15)',

            fill:true,

            tension:.4,

            pointRadius:5,

            pointBackgroundColor:'#6366F1'

        }]

    },

    options:{

        responsive:true,

        plugins:{

            legend:{
                display:false
            }

        }

    }

});

</script>

@endsection