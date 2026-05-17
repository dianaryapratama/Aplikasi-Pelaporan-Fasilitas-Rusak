@extends('layouts.warga')

@section('title', 'Dashboard Saya - e-Layanan Desa')

@section('content')
    <!-- Header -->
    <div class="mb-6 sm:mb-8 text-center sm:text-left">
        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-800 tracking-tight">Halo, {{ Auth::user()->name }}! 👋</h2>
        <p class="text-sm sm:text-base text-slate-500 mt-1 sm:mt-2">Pantau terus status laporan kerusakan fasilitas yang telah Anda ajukan.</p>
    </div>

    <!-- Kartu Statistik (Responsive Grid) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8 sm:mb-10">
        <!-- Menunggu -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-100 shadow-sm flex items-center gap-4 hover:shadow-md transition-shadow">
            <div class="w-12 h-12 rounded-full bg-orange-50 flex items-center justify-center text-orange-500 text-xl shrink-0">🟡</div>
            <div>
                <p class="text-[11px] uppercase tracking-wider font-bold text-slate-400">Menunggu</p>
                <h3 class="text-2xl font-black text-slate-800 leading-none mt-1">{{ $statMenunggu }}</h3>
            </div>
        </div>
        <!-- Proses -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-100 shadow-sm flex items-center gap-4 hover:shadow-md transition-shadow">
            <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center text-blue-500 text-xl shrink-0">🔵</div>
            <div>
                <p class="text-[11px] uppercase tracking-wider font-bold text-slate-400">Diproses</p>
                <h3 class="text-2xl font-black text-slate-800 leading-none mt-1">{{ $statProses }}</h3>
            </div>
        </div>
        <!-- Selesai -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-100 shadow-sm flex items-center gap-4 sm:col-span-2 lg:col-span-1 hover:shadow-md transition-shadow">
            <div class="w-12 h-12 rounded-full bg-green-50 flex items-center justify-center text-green-500 text-xl shrink-0">🟢</div>
            <div>
                <p class="text-[11px] uppercase tracking-wider font-bold text-slate-400">Selesai</p>
                <h3 class="text-2xl font-black text-slate-800 leading-none mt-1">{{ $statSelesai }}</h3>
            </div>
        </div>
    </div>

    <!-- Riwayat Laporan Warga -->
    <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center justify-center sm:justify-start gap-2">
        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
        Riwayat Laporan Anda
    </h3>

    @if($laporans->count() > 0)
        <div class="space-y-5">
            @foreach($laporans as $laporan)
            <div class="bg-white rounded-3xl p-5 sm:p-6 border border-slate-100 shadow-sm hover:shadow-md transition">
                <div class="flex flex-col lg:flex-row gap-5 lg:gap-6">
                    
                    <!-- Atas/Kiri: Info Dasar -->
                    <div class="flex-1">
                        <div class="flex flex-wrap items-center justify-between gap-2 mb-3">
                            <span class="text-[11px] sm:text-xs font-semibold text-slate-400">{{ \Carbon\Carbon::parse($laporan->tgl_lapor)->translatedFormat('l, d M Y - H:i') }} WIB</span>
                            
                            <!-- Badge Status -->
                            @if($laporan->status == 'Menunggu')
                                <span class="bg-orange-50 text-orange-600 border border-orange-200 px-2.5 sm:px-3 py-1 rounded-full text-[10px] sm:text-xs font-bold flex items-center gap-1.5 shrink-0">
                                    <span class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse"></span> Menunggu
                                </span>
                            @elseif($laporan->status == 'Proses')
                                <span class="bg-blue-50 text-blue-600 border border-blue-200 px-2.5 sm:px-3 py-1 rounded-full text-[10px] sm:text-xs font-bold flex items-center gap-1.5 shrink-0">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span> Diperbaiki
                                </span>
                            @else
                                <span class="bg-green-50 text-green-600 border border-green-200 px-2.5 sm:px-3 py-1 rounded-full text-[10px] sm:text-xs font-bold flex items-center gap-1.5 shrink-0">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg> Selesai
                                </span>
                            @endif
                        </div>

                        <h4 class="text-lg sm:text-xl font-bold text-slate-800 mb-1">{{ $laporan->nama_fasilitas }}</h4>
                        <p class="text-xs sm:text-sm text-slate-500 font-medium mb-3">Kategori: <span class="text-slate-700">{{ $laporan->jenis_kerusakan }}</span></p>
                        <p class="text-slate-600 text-sm leading-relaxed bg-slate-50 p-3 sm:p-4 rounded-2xl border border-slate-100 break-words">{{ $laporan->deskripsi }}</p>
                    </div>

                    <!-- Bawah/Kanan: Tindak Lanjut -->
                    <div class="lg:w-1/3 flex flex-col justify-center mt-2 lg:mt-0">
                        <div class="bg-blue-50/50 p-4 rounded-2xl border border-blue-100 h-full flex flex-col relative overflow-hidden">
                            <div class="absolute -right-4 -top-4 w-16 h-16 bg-blue-100 rounded-full opacity-50"></div>

                            <p class="text-[10px] uppercase font-bold text-blue-500 tracking-wider mb-2 flex items-center gap-1 relative z-10">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                                Catatan Tindak Lanjut
                            </p>
                            
                            @if($laporan->catatan_petugas)
                                <p class="text-sm font-medium text-slate-700 italic relative z-10">"{{ $laporan->catatan_petugas }}"</p>
                                <div class="mt-auto pt-3 flex items-center gap-2 relative z-10">
                                    <div class="w-6 h-6 bg-blue-200 rounded-full flex items-center justify-center text-[10px] font-bold text-blue-700">A</div>
                                    <span class="text-xs font-semibold text-slate-500">Admin Desa</span>
                                </div>
                            @else
                                <div class="flex flex-col items-center justify-center h-full opacity-60 text-center py-4 relative z-10">
                                    <span class="text-2xl mb-1">⏳</span>
                                    <p class="text-xs font-medium text-slate-500">Belum ada tanggapan teknis.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
            @endforeach
        </div>
    @else
        <!-- Jika Kosong -->
        <div class="bg-white rounded-3xl border border-slate-100 p-8 sm:p-10 text-center shadow-sm mx-4 sm:mx-0">
            <div class="w-20 h-20 sm:w-24 sm:h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl sm:text-4xl">📝</div>
            <h4 class="text-base sm:text-lg font-bold text-slate-800 mb-2">Belum Ada Laporan</h4>
            <p class="text-sm sm:text-base text-slate-500 max-w-sm mx-auto mb-6">Anda belum pernah mengajukan laporan kerusakan fasilitas apa pun.</p>
            <a href="{{ route('lapor.web') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-xl transition shadow-lg shadow-blue-500/30 text-sm sm:text-base">
                Buat Laporan Sekarang
            </a>
        </div>
    @endif
@endsection