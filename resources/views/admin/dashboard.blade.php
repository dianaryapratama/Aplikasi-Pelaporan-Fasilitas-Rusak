@extends('layouts.app')

@section('title', 'Dashboard Admin - Fasilitas Rusak')
@section('header_title', 'Ringkasan & Statistik Laporan')

@section('content')
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center gap-5 hover:shadow-md transition">
            <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            </div>
            <div>
                <p class="text-slate-500 text-sm font-medium mb-1">Total Laporan</p>
                <p class="text-3xl font-extrabold text-slate-800">{{ $totalLaporan ?? 0 }}</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center gap-5 hover:shadow-md transition">
            <div class="w-14 h-14 rounded-2xl bg-orange-50 text-orange-500 flex items-center justify-center shrink-0">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-slate-500 text-sm font-medium mb-1">Menunggu Respon</p>
                <p class="text-3xl font-extrabold text-slate-800">{{ $menunggu ?? 0 }}</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center gap-5 hover:shadow-md transition">
            <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            </div>
            <div>
                <p class="text-slate-500 text-sm font-medium mb-1">Sedang Diproses</p>
                <p class="text-3xl font-extrabold text-slate-800">{{ $proses ?? 0 }}</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center gap-5 hover:shadow-md transition">
            <div class="w-14 h-14 rounded-2xl bg-green-50 text-green-600 flex items-center justify-center shrink-0">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-slate-500 text-sm font-medium mb-1">Selesai Diperbaiki</p>
                <p class="text-3xl font-extrabold text-slate-800">{{ $selesai ?? 0 }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 mb-8 w-full">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 class="font-bold text-lg text-slate-800">Tren Pelaporan Bulanan</h3>
                <p class="text-xs text-slate-500">Jumlah laporan kerusakan yang masuk sepanjang tahun {{ date('Y') }}</p>
            </div>
        </div>
        <div class="relative w-full flex items-center justify-center" style="height: 300px;">
            <canvas id="trenChart"></canvas>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex flex-col h-full">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bold text-lg text-slate-800">Statistik Status</h3>
                <select id="chartType" onchange="updateStatusChart()" class="text-xs bg-slate-50 border border-slate-200 text-slate-700 rounded-xl px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer">
                    <option value="doughnut">Doughnut</option>
                    <option value="pie">Pie Chart</option>
                    <option value="bar">Bar Chart</option>
                    <option value="polarArea">Polar Area</option>
                </select>
            </div>
            <div class="relative flex-1 w-full flex items-center justify-center" style="min-height: 280px;">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex flex-col h-full">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bold text-lg text-slate-800">Distribusi Kategori Kerusakan</h3>
            </div>
            <div class="relative flex-1 w-full flex items-center justify-center" style="min-height: 280px;">
                <canvas id="kategoriChart"></canvas>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 w-full mb-8">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-bold text-lg text-slate-800">Laporan Masuk Terbaru</h3>
            <a href="#" class="text-sm text-blue-600 font-medium hover:underline">Lihat Semua</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-200 text-slate-500 text-sm">
                        <th class="py-3 px-4 font-medium">Fasilitas</th>
                        <th class="py-3 px-4 font-medium">Kategori Kerusakan</th>
                        <th class="py-3 px-4 font-medium text-center">Tanggal</th>
                        <th class="py-3 px-4 font-medium text-center">Status</th>
                        <th class="py-3 px-4 font-medium text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-700">
                    @forelse($laporans as $laporan)
                    <tr class="border-b border-slate-50 hover:bg-slate-50 transition">
                        <td class="py-4 px-4">
                            <p class="font-bold text-slate-900">{{ $laporan->nama_fasilitas }}</p>
                            <p class="text-xs text-slate-500">{{ $laporan->user->name ?? 'Anonim' }}</p>
                        </td>
                        <td class="py-4 px-4">
                            <span class="bg-slate-100 text-slate-600 py-1 px-3 rounded-full text-xs font-semibold border border-slate-200">
                                {{ $laporan->jenis_kerusakan }}
                            </span>
                        </td>
                        <td class="py-4 px-4 text-center text-slate-500">
                            {{ \Carbon\Carbon::parse($laporan->tgl_lapor)->format('d M Y') }}
                        </td>
                        <td class="py-4 px-4 text-center">
                            @if($laporan->status == 'Menunggu')
                                <span class="inline-flex items-center gap-1.5 bg-orange-50 text-orange-600 py-1 px-3 rounded-full text-xs font-bold border border-orange-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse"></span> Menunggu
                                </span>
                            @elseif($laporan->status == 'Proses')
                                <span class="inline-flex items-center gap-1.5 bg-blue-50 text-blue-600 py-1 px-3 rounded-full text-xs font-bold border border-blue-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Diproses
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 bg-green-50 text-green-600 py-1 px-3 rounded-full text-xs font-bold border border-green-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Selesai
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-4 text-center">
                            <a href="{{ route('admin.laporan.show', $laporan->id_laporan) }}" class="inline-flex items-center justify-center bg-white border border-slate-300 text-slate-700 hover:bg-blue-50 hover:text-blue-600 hover:border-blue-300 w-8 h-8 rounded-lg transition shadow-sm" title="Respon & Detail">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center text-slate-400">
                            <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                            <p>Belum ada data laporan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            {{ $laporans->links() }}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // ==========================================
        // 1. SCRIPT CHART TREN BULANAN (GARIS)
        // ==========================================
        const dataTrenRaw = {!! json_encode($chartTren ?? ['labels' => [], 'data' => []]) !!};
        
        function renderTrenChart() {
            const ctxTren = document.getElementById('trenChart').getContext('2d');
            
            // Gradient fill untuk line chart
            let gradient = ctxTren.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(59, 130, 246, 0.4)'); // Blue-500
            gradient.addColorStop(1, 'rgba(59, 130, 246, 0)');

            new Chart(ctxTren, {
                type: 'line', 
                data: {
                    labels: dataTrenRaw.labels,
                    datasets: [{
                        label: 'Laporan Masuk',
                        data: dataTrenRaw.data,
                        borderColor: '#3B82F6', // Blue-500
                        backgroundColor: gradient,
                        borderWidth: 3,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#3B82F6',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true,
                        tension: 0.4 // Membuat garis melengkung (smooth)
                    }]
                },
                options: {
                    responsive: true, 
                    maintainAspectRatio: false,
                    plugins: { 
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.9)',
                            titleFont: { family: "'Inter', sans-serif", size: 13 },
                            bodyFont: { family: "'Inter', sans-serif", size: 14, weight: 'bold' },
                            padding: 12,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.y + ' Laporan';
                                }
                            }
                        }
                    },
                    scales: {
                        x: { 
                            grid: { display: false, drawBorder: false },
                            ticks: { font: { family: "'Inter', sans-serif" }, color: '#64748b' }
                        },
                        y: { 
                            beginAtZero: true, 
                            grid: { borderDash: [4, 4], color: '#f1f5f9', drawBorder: false },
                            ticks: { precision: 0, font: { family: "'Inter', sans-serif" }, color: '#64748b' }
                        }
                    }
                }
            });
        }

        // ==========================================
        // 2. SCRIPT CHART.JS (Status & Kategori)
        // ==========================================
        
        // --- A. Chart Status Laporan ---
        const dataStatus = {
            labels: ['Menunggu', 'Diproses', 'Selesai'],
            datasets: [{
                data: [{{ $menunggu ?? 0 }}, {{ $proses ?? 0 }}, {{ $selesai ?? 0 }}],
                backgroundColor: ['#F97316', '#3B82F6', '#22C55E'], 
                borderColor: '#ffffff',
                borderWidth: 3,
                hoverOffset: 5,
                borderRadius: 4
            }]
        };

        let statusChart;
        function updateStatusChart() {
            const ctxStatus = document.getElementById('statusChart').getContext('2d');
            const typeStatus = document.getElementById('chartType').value;

            if (statusChart) statusChart.destroy();

            statusChart = new Chart(ctxStatus, {
                type: typeStatus,
                data: dataStatus,
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom', labels: { usePointStyle: true, font: { family: "'Inter', sans-serif" } } }
                    },
                    scales: (typeStatus === 'bar') ? { y: { beginAtZero: true, ticks: { precision: 0 } } } : {}
                }
            });
        }

        // --- B. Chart Kategori ---
        const dataKategoriRaw = {!! json_encode($chartKategori ?? ['labels' => [], 'data' => []]) !!};
        const dataKategori = {
            labels: dataKategoriRaw.labels.length > 0 ? dataKategoriRaw.labels : ['Belum Ada Data'],
            datasets: [{
                label: 'Total Laporan',
                data: dataKategoriRaw.data.length > 0 ? dataKategoriRaw.data : [0],
                backgroundColor: 'rgba(99, 102, 241, 0.85)',
                borderColor: 'rgba(99, 102, 241, 1)',
                borderWidth: 1,
                borderRadius: 6,
                barPercentage: 0.6
            }]
        };

        function renderKategoriChart() {
            const ctxKategori = document.getElementById('kategoriChart').getContext('2d');
            new Chart(ctxKategori, {
                type: 'bar', 
                data: dataKategori,
                options: {
                    responsive: true, maintainAspectRatio: false,
                    indexAxis: 'y', // Horizontal Bar Chart
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { beginAtZero: true, ticks: { precision: 0 } },
                        y: { grid: { display: false } }
                    }
                }
            });
        }

        // Jalankan semua render chart saat halaman siap
        document.addEventListener('DOMContentLoaded', function() {
            renderTrenChart();
            updateStatusChart();
            renderKategoriChart();
        });
    </script>
@endsection