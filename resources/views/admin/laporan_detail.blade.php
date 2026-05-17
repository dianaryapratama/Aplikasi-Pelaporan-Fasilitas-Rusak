@extends('layouts.app')

@section('title', 'Detail Laporan - Fasilitas Rusak')
@section('header_title', 'Tindak Lanjut Laporan')

@section('content')

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>

<style>
    @keyframes pulse-dot {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.6); opacity: 0.5; }
    }
</style>

<div class="max-w-6xl mx-auto space-y-6">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-2">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.dashboard') }}" class="p-2 bg-white text-slate-500 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition shadow-sm border border-slate-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-slate-800 leading-tight">Detail Laporan <span class="text-blue-600">#{{ $laporan->id_laporan }}</span></h2>
                <p class="text-sm text-slate-500">Pemantauan dan penanganan fasilitas desa</p>
            </div>
        </div>
    </div>

    <div class="bg-white/90 backdrop-blur-xl rounded-3xl shadow-sm border border-slate-100 overflow-hidden flex flex-col lg:flex-row">
        
        <div class="p-8 lg:w-1/2 border-b lg:border-b-0 lg:border-r border-slate-100 bg-slate-50/50">
            <h3 class="font-bold text-lg mb-6 text-slate-800 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">📋</span>
                Informasi Kerusakan
            </h3>
            
            <div class="space-y-6">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold mb-1">Pelapor</p>
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 bg-slate-200 rounded-full flex items-center justify-center text-xs font-bold text-slate-600">
                                {{ substr($laporan->user->name ?? 'A', 0, 1) }}
                            </div>
                            <p class="font-medium text-slate-700">{{ $laporan->user->name ?? 'Anonim' }}</p>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold mb-1">Waktu Laporan</p>
                        <p class="font-medium text-slate-700 text-sm">
                            {{ \Carbon\Carbon::parse($laporan->tgl_lapor)->translatedFormat('d M Y, H:i') }} WIB
                        </p>
                    </div>
                </div>

                <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
                    <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold mb-1">Fasilitas Terdampak</p>
                    <p class="font-bold text-slate-900 text-xl">{{ $laporan->nama_fasilitas }}</p>
                </div>

                <div>
                    <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold mb-2">Tingkat Kerusakan</p>
                    <span class="inline-flex items-center bg-red-50 text-red-600 border border-red-100 py-1.5 px-4 rounded-full text-sm font-bold shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-red-500 mr-2 animate-pulse"></span>
                        {{ $laporan->jenis_kerusakan }}
                    </span>
                </div>

                <div>
                    <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold mb-2">Deskripsi Laporan</p>
                    <div class="text-slate-600 bg-white p-5 rounded-2xl border border-slate-100 shadow-sm text-sm leading-relaxed relative">
                        <svg class="absolute top-4 right-4 w-6 h-6 text-slate-200" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
                        {{ $laporan->deskripsi }}
                    </div>
                </div>

                @if($laporan->foto_bukti)
                <div>
                    <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold mb-2">Foto Bukti</p>
                    <div class="w-full h-48 rounded-2xl overflow-hidden border border-slate-200 shadow-sm">
                        <img src="{{ asset('storage/' . $laporan->foto_bukti) }}" alt="Foto Bukti" class="w-full h-full object-cover">
                    </div>
                </div>
                @endif
            </div>
        </div>

        <div class="p-8 lg:w-1/2">
            <h3 class="font-bold text-lg mb-6 text-slate-800 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-orange-100 text-orange-600 flex items-center justify-center">🛠️</span>
                Tindakan Petugas
            </h3>

            <form action="{{ route('admin.laporan.update', $laporan->id_laporan) }}" method="POST" class="flex flex-col h-[calc(100%-3rem)]">
                @csrf
                @method('PUT')

                <div class="mb-5">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Perbarui Status</label>
                    <div class="relative">
                        <select name="status" class="block w-full appearance-none bg-slate-50 border border-slate-200 text-slate-700 py-3.5 px-4 pr-8 rounded-xl focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-medium transition cursor-pointer">
                            <option value="Menunggu" {{ $laporan->status == 'Menunggu' ? 'selected' : '' }}>🟡 Menunggu (Belum direspon)</option>
                            <option value="Proses" {{ $laporan->status == 'Proses' ? 'selected' : '' }}>🔵 Proses (Sedang dikerjakan)</option>
                            <option value="Selesai" {{ $laporan->status == 'Selesai' ? 'selected' : '' }}>🟢 Selesai (Sudah diperbaiki)</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400">
                            <svg class="fill-current h-4 w-4" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>

                <div class="mb-6 flex-1">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Catatan untuk Warga (Opsional)</label>
                    <textarea name="catatan_petugas" rows="5" class="w-full h-32 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 p-4 transition resize-none text-sm" placeholder="Misal: Tim teknis akan segera menuju lokasi...">{{ $laporan->catatan_petugas }}</textarea>
                    <p class="text-xs text-slate-400 mt-2 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Catatan ini akan langsung terlihat oleh pelapor di aplikasinya.
                    </p>
                </div>

                <button type="submit" class="w-full mt-auto bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-4 rounded-xl shadow-lg shadow-blue-600/30 transition transform hover:-translate-y-0.5 flex justify-center items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                    Simpan Perubahan Laporan
                </button>
            </form>
        </div>
    </div>

    <div class="bg-white/90 backdrop-blur-xl rounded-3xl shadow-sm border border-slate-100 p-6 md:p-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6 border-b border-slate-100 pb-4">
            <h3 class="font-bold text-lg text-slate-800 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-green-100 text-green-600 flex items-center justify-center">📍</span>
                Pemetaan & Rute Evakuasi
            </h3>
            
            @if($laporan->latitude && $laporan->longitude)
            <div class="flex flex-wrap items-center gap-3">
                <div class="relative group">
                    <select id="transportMode" onchange="updateEstimation()" class="bg-slate-100 border-none text-slate-700 text-xs font-bold py-2.5 px-4 rounded-xl focus:ring-2 focus:ring-blue-500 cursor-pointer appearance-none pr-10">
                        <option value="car">🚗 Mobil / Pick-up</option>
                        <option value="motorcycle" selected>🏍️ Sepeda Motor</option>
                        <option value="bicycle">🚲 Sepeda</option>
                        <option value="walking">🚶 Jalan Kaki</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>

                <button onclick="startNavigation()" id="btnNav" class="inline-flex items-center gap-2 bg-slate-900 text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-md hover:bg-slate-800 transition transform hover:-translate-y-0.5">
                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    Mulai Perjalanan
                </button>
                <button onclick="stopNavigation()" id="btnStop" class="hidden inline-flex items-center gap-2 bg-red-50 text-red-600 border border-red-200 px-5 py-2.5 rounded-xl text-sm font-bold shadow-sm hover:bg-red-100 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"></path></svg>
                    Berhenti
                </button>
            </div>
            @endif
        </div>
        
        @if($laporan->latitude && $laporan->longitude)
            <div id="mapContainer" class="relative overflow-hidden rounded-2xl border border-slate-200 shadow-inner z-0 mb-4">
                
                <div id="map" style="height: 550px; width: 100%;"></div>
                
                <div id="routeInfo" class="absolute bottom-4 left-4 z-[400] bg-white/95 backdrop-blur-sm p-4 rounded-2xl shadow-lg border border-slate-100 flex flex-col gap-1">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> 
                        Estimasi Rute
                    </span>
                    <span id="estTime" class="text-lg font-black text-blue-600 leading-none">--</span>
                    <span id="estDist" class="text-xs font-medium text-slate-500 mt-1">Jarak: -- km</span>
                </div>

                <div id="navTurnPanel" class="absolute top-4 left-4 right-4 md:w-96 z-[500] hidden flex-col gap-2 pointer-events-none"></div>

            </div>
            
            <div class="flex items-start gap-3 text-sm text-slate-600 bg-blue-50/50 p-4 rounded-xl border border-blue-100">
                <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shrink-0 mt-0.5">ℹ️</span>
                <p class="leading-relaxed">
                    Secara default, garis biru menunjukkan rute dari <strong>Kantor Desa</strong>. Anda dapat memilih moda transportasi di atas untuk melihat estimasi waktu tempuh. Klik tombol <strong class="text-slate-900">"Mulai Perjalanan"</strong> untuk melacak posisi Anda saat ini secara real-time dan memunculkan panel panduan arah.
                </p>
            </div>

            <script>
                @php
                    $setting = \App\Models\Setting::first();
                    $latKantor = $setting->latitude_kantor ?? 3.5952;
                    $lngKantor = $setting->longitude_kantor ?? 98.6722;
                    $namaDesa = $setting->nama_desa ?? 'Kantor Desa';
                @endphp

                var kantorDesa = [{{ $latKantor }}, {{ $lngKantor }}]; 
                var lokasiLaporan = [{{ $laporan->latitude }}, {{ $laporan->longitude }}];
                
                var map = L.map('map').setView(lokasiLaporan, 14);
                var userMarker = null;
                var watchId = null;
                var isNavigating = false;
                
                // Variabel penyimpan data Rute OSRM
                var currentSteps = [];
                var currentCoordinates = [];
                var totalDistance = 0;

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap'
                }).addTo(map);

                const speeds = { car: 35, motorcycle: 40, bicycle: 15, walking: 5 };

                // 1. INISIALISASI ROUTING (Hanya 1 rute utama)
                var routingControl = L.Routing.control({
                    waypoints: [
                        L.latLng(kantorDesa[0], kantorDesa[1]),
                        L.latLng(lokasiLaporan[0], lokasiLaporan[1])
                    ],
                    routeWhileDragging: false,
                    addWaypoints: false,
                    show: false, // Sembunyikan panel default bawaan Leaflet
                    router: L.Routing.osrmv1({
                        serviceUrl: 'https://router.project-osrm.org/route/v1',
                        profile: 'car'
                    }),
                    alternatives: false, // MATIKAN Opsi Jalan Lain
                    lineOptions: { 
                        styles: [{color: '#3B82F6', opacity: 0.9, weight: 7}]
                    },
                    createMarker: function(i, wp) {
                        var iconUrl = i === 0 ? 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png' : 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png';
                        return L.marker(wp.latLng, {
                            icon: new L.Icon({ iconUrl: iconUrl, shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png', iconSize: [25, 41], iconAnchor: [12, 41] })
                        }).bindPopup(i === 0 ? `<b>🏢 {{ $namaDesa }}</b><br>Titik Awal` : `<b>⚠️ Lokasi Laporan</b><br>{{ $laporan->nama_fasilitas }}`);
                    }
                }).on('routesfound', function(e) {
                    var route = e.routes[0];
                    totalDistance = route.summary.totalDistance; // dalam meter
                    currentSteps = route.instructions || [];
                    currentCoordinates = route.coordinates || [];
                    
                    // Fit bounds hanya saat pertama load
                    if(!isNavigating) {
                        var bounds = L.latLngBounds(route.coordinates);
                        map.fitBounds(bounds, { padding: [40, 40] });
                        updateEstimation();
                    }
                }).addTo(map);

                // 2. FUNGSI ESTIMASI STATIS (Info Bawah Kiri)
                window.updateEstimation = function() {
                    if (totalDistance === 0 || isNavigating) return;
                    var mode = document.getElementById('transportMode').value;
                    var distKm = totalDistance / 1000;
                    var timeMins = Math.round((distKm / speeds[mode]) * 60);
                    var displayTime = timeMins >= 60 ? Math.floor(timeMins/60) + "j " + (timeMins%60) + "m" : timeMins + " menit";
                    
                    document.getElementById('estTime').innerText = displayTime;
                    document.getElementById('estDist').innerText = `Jarak: ${distKm.toFixed(2)} km`;
                };

                // 3. FUNGSI UI TURN-BY-TURN
                function getArrowSVG(type) {
                    const arrows = {
                        'Straight': `<svg width="32" height="32" viewBox="0 0 40 40"><path d="M20 38 L20 8" stroke="#fff" stroke-width="4" fill="none" stroke-linecap="round"/><polygon points="20,2 12,14 28,14" fill="#fff"/></svg>`,
                        'TurnRight': `<svg width="32" height="32" viewBox="0 0 40 40"><path d="M10 38 L10 18 Q10 10 18 10 L32 10" stroke="#fff" stroke-width="4" fill="none" stroke-linecap="round" stroke-linejoin="round"/><polygon points="30,3 38,10 30,17" fill="#fff"/></svg>`,
                        'TurnLeft': `<svg width="32" height="32" viewBox="0 0 40 40"><path d="M30 38 L30 18 Q30 10 22 10 L8 10" stroke="#fff" stroke-width="4" fill="none" stroke-linecap="round" stroke-linejoin="round"/><polygon points="10,3 2,10 10,17" fill="#fff"/></svg>`,
                        'DestinationReached': `<svg width="32" height="32" viewBox="0 0 40 40"><circle cx="20" cy="18" r="10" fill="#fff" stroke="#EF4444" stroke-width="2"/><circle cx="20" cy="18" r="4" fill="#EF4444"/><line x1="20" y1="28" x2="20" y2="38" stroke="#fff" stroke-width="3" stroke-linecap="round"/></svg>`,
                    };
                    return arrows[type] || arrows['Straight'];
                }

                function translateInstruction(step) {
                    const typeMap = {
                        'Straight': 'Lanjutkan lurus', 'SlightRight': 'Sedikit ke kanan', 'Right': 'Belok kanan', 'SharpRight': 'Belok kanan tajam',
                        'Left': 'Belok kiri', 'SlightLeft': 'Sedikit ke kiri', 'SharpLeft': 'Belok kiri tajam', 'TurnAround': 'Balik arah',
                        'Roundabout': 'Masuk bundaran', 'DestinationReached': 'Tiba di tujuan'
                    };
                    return typeMap[step.type] || step.text || 'Lanjutkan perjalanan';
                }

                // 4. ALGORITMA UPDATE PANEL NAVIGASI (Turn by Turn)
                function updateNavPanel(userLatLng) {
                    if (!currentSteps || currentSteps.length === 0 || !currentCoordinates || currentCoordinates.length === 0) return;

                    // A. Cari Index Koordinat Terdekat
                    let minCIdx = 0;
                    let minDist = Infinity;
                    let searchLimit = Math.min(currentCoordinates.length, 500); 
                    for(let i = 0; i < searchLimit; i++) {
                        let d = userLatLng.distanceTo(L.latLng(currentCoordinates[i]));
                        if(d < minDist) { minDist = d; minCIdx = i; }
                    }

                    // B. Cari Step (Instruksi) berdasarkan index koordinat tersebut
                    let activeStepIdx = 0;
                    for(let i = 0; i < currentSteps.length; i++) {
                        if(currentSteps[i].index !== undefined && currentSteps[i].index <= minCIdx) { 
                            activeStepIdx = i; 
                        } else { break; }
                    }

                    let step = currentSteps[activeStepIdx];
                    let nextStep = currentSteps[activeStepIdx + 1];
                    
                    // C. Hitung Jarak ke Belokan Berikutnya
                    let distToTurn = 0;
                    if(nextStep && nextStep.index !== undefined && currentCoordinates[nextStep.index]) {
                        distToTurn = userLatLng.distanceTo(L.latLng(currentCoordinates[nextStep.index]));
                    } else {
                        distToTurn = userLatLng.distanceTo(L.latLng(lokasiLaporan)); // Jarak ke finish
                    }

                    // Render ke Layar
                    const panel = document.getElementById('navTurnPanel');
                    let distText = distToTurn >= 1000 ? (distToTurn/1000).toFixed(1) + ' km' : Math.round(distToTurn) + ' m';
                    let instruction = translateInstruction(step);
                    
                    let arrowType = 'Straight';
                    if(nextStep) {
                        let nt = nextStep.type;
                        if(nt.includes('Right')) arrowType = 'TurnRight';
                        if(nt.includes('Left')) arrowType = 'TurnLeft';
                        if(nt === 'DestinationReached') arrowType = 'DestinationReached';
                    } else if(step.type === 'DestinationReached') {
                        arrowType = 'DestinationReached';
                        instruction = "Anda telah tiba";
                        distText = "0 m";
                    }

                    let roadName = step.road || step.name || 'Ikuti jalan';

                    // Hitung Sisa Waktu
                    let totalRemainingDist = distToTurn;
                    for(let i = activeStepIdx + 1; i < currentSteps.length; i++) {
                        totalRemainingDist += currentSteps[i].distance;
                    }
                    let mode = document.getElementById('transportMode').value;
                    let minsLeft = Math.round((totalRemainingDist / 1000) / speeds[mode] * 60);
                    let timeText = minsLeft >= 60 ? Math.floor(minsLeft/60) + 'j ' + (minsLeft%60) + 'm' : minsLeft + ' mnt';

                    // UI Panel Gelap Persis Google Maps
                    panel.innerHTML = `
                        <div style="background:#1C2340;border-radius:16px;padding:16px;box-shadow:0 10px 25px rgba(0,0,0,.3);pointer-events:auto;">
                            <div style="display:flex;align-items:center;gap:16px;">
                                <div style="width:48px;height:48px;background:rgba(255,255,255,.1);border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    ${getArrowSVG(arrowType)}
                                </div>
                                <div style="flex:1;min-width:0;">
                                    <div style="color:rgba(255,255,255,.6);font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;margin-bottom:2px;">Lanjutkan Dalam</div>
                                    <div style="color:#fff;font-size:32px;font-weight:700;line-height:1;margin-bottom:4px;">${distText}</div>
                                    <div style="color:#60A5FA;font-size:14px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">${roadName}</div>
                                </div>
                                <div style="background:rgba(255,255,255,.1);border-radius:12px;padding:10px 12px;text-align:center;min-width:70px;">
                                    <div style="color:#fff;font-size:16px;font-weight:700;">${timeText}</div>
                                    <div style="color:rgba(255,255,255,.5);font-size:10px;margin-top:2px;">tersisa</div>
                                </div>
                            </div>
                        </div>
                        
                        ${nextStep ? `
                        <div style="background:rgba(255,255,255,.95);backdrop-filter:blur(5px);border-radius:12px;padding:12px 16px;display:flex;align-items:center;gap:12px;box-shadow:0 4px 15px rgba(0,0,0,.1);pointer-events:auto;">
                            <div style="color:#64748B;">
                                <svg width="20" height="20" viewBox="0 0 40 40">${getArrowSVG(arrowType).replace(/#fff/g, '#64748B')}</svg>
                            </div>
                            <div>
                                <div style="font-size:11px;color:#94A3B8;font-weight:600;margin-bottom:2px;">Selanjutnya</div>
                                <div style="font-size:14px;font-weight:700;color:#1E293B;">${translateInstruction(nextStep)}</div>
                            </div>
                        </div>` : ''}
                    `;
                }

                // 5. KONTROL GPS REAL-TIME
                window.startNavigation = function() {
                    if (!navigator.geolocation) { alert("GPS tidak didukung."); return; }
                    
                    isNavigating = true;
                    document.getElementById('btnNav').classList.add('hidden');
                    document.getElementById('btnStop').classList.remove('hidden');
                    document.getElementById('routeInfo').style.display = 'none'; // Sembunyikan estimasi statis
                    document.getElementById('navTurnPanel').style.display = 'flex'; // Munculkan panel gelap

                    watchId = navigator.geolocation.watchPosition(function(pos) {
                        var userLatLng = L.latLng(pos.coords.latitude, pos.coords.longitude);

                        // Buat titik biru user
                        if (!userMarker) {
                            var dotIcon = L.divIcon({
                                className: '',
                                html: `<div style="position:relative;width:20px;height:20px;">
                                        <div style="position:absolute;width:100%;height:100%;border-radius:50%;background:rgba(59,130,246,0.4);animation:pulse-dot 2s infinite;"></div>
                                        <div style="position:absolute;top:3px;left:3px;width:14px;height:14px;border-radius:50%;background:#2563EB;border:2px solid #fff;"></div>
                                       </div>`,
                                iconSize: [20, 20], iconAnchor: [10, 10]
                            });
                            userMarker = L.marker(userLatLng, { icon: dotIcon }).addTo(map);
                        } else { 
                            userMarker.setLatLng(userLatLng); 
                        }

                        map.panTo(userLatLng);
                        
                        // Ubah Rute agar bermula dari GPS Admin
                        routingControl.setWaypoints([userLatLng, L.latLng(lokasiLaporan[0], lokasiLaporan[1])]);
                        
                        // Perbarui panel instruksi belokan
                        updateNavPanel(userLatLng);

                    }, function(error) { 
                        alert("Gagal melacak lokasi. Pastikan GPS HP menyala."); stopNavigation(); 
                    }, { enableHighAccuracy: true });
                };

                window.stopNavigation = function() {
                    isNavigating = false;
                    if (watchId) { navigator.geolocation.clearWatch(watchId); watchId = null; }
                    if (userMarker) { map.removeLayer(userMarker); userMarker = null; }
                    
                    document.getElementById('btnNav').classList.remove('hidden');
                    document.getElementById('btnStop').classList.add('hidden');
                    document.getElementById('navTurnPanel').style.display = 'none';
                    document.getElementById('routeInfo').style.display = 'flex';
                    
                    // Kembalikan rute ke default (Kantor Desa -> Lokasi Rusak)
                    routingControl.setWaypoints([L.latLng(kantorDesa[0], kantorDesa[1]), L.latLng(lokasiLaporan[0], lokasiLaporan[1])]);
                    map.setView(lokasiLaporan, 14);
                };
            </script>

        @else
            <div class="bg-slate-50 py-16 rounded-2xl border-2 border-dashed border-slate-200 flex flex-col items-center justify-center text-center px-4">
                <div class="w-20 h-20 bg-slate-200 rounded-full flex items-center justify-center mb-4">
                    <span class="text-4xl">📡</span>
                </div>
                <h4 class="text-xl font-bold text-slate-700 mb-2">Koordinat Tidak Tersedia</h4>
                <p class="text-slate-500 max-w-md">
                    Pelapor tidak melampirkan titik koordinat GPS saat mengirim laporan ini. Harap periksa rincian deskripsi secara manual.
                </p>
            </div>
        @endif
    </div>
</div>
@endsection