@extends('layouts.warga')

@section('title', 'Buat Laporan - e-Layanan Desa')

@section('content')
<!-- Memuat CSS & JS Leaflet untuk Peta -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<!-- Memuat SweetAlert2 untuk Pop-up -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="max-w-4xl mx-auto">
    
    <!-- Header -->
    <div class="mb-6 sm:mb-8 text-center sm:text-left">
        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-800 tracking-tight">Formulir Laporan Warga</h2>
        <p class="text-sm sm:text-base text-slate-500 mt-1 sm:mt-2">Laporkan fasilitas umum yang rusak di wilayah desa agar segera ditindaklanjuti.</p>
    </div>

    <!-- Form Container -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <form action="{{ route('lapor.web.store') }}" method="POST" enctype="multipart/form-data" class="p-5 sm:p-8">
            @csrf

            <!-- 1. LOKASI PETA -->
            <div class="mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 gap-3">
                    <label class="block text-sm font-bold text-slate-700 uppercase tracking-wide">Titik Lokasi Kerusakan <span class="text-red-500">*</span></label>
                    <button type="button" onclick="getLocation()" class="text-xs bg-blue-50 text-blue-600 hover:bg-blue-100 font-bold py-2 px-3 rounded-xl transition flex items-center justify-center gap-1.5 border border-blue-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path></svg>
                        Gunakan GPS Saya Saat Ini
                    </button>
                </div>

                <p class="text-xs sm:text-sm text-slate-500 mb-4 border-l-4 border-blue-500 pl-3 bg-slate-50 py-2 rounded-r-lg">
                    Geser pin merah pada peta persis ke lokasi fasilitas yang rusak. <b>Wajib berada di dalam area garis biru.</b>
                </p>

                <div id="map" class="w-full h-[300px] sm:h-[400px] rounded-2xl border-2 border-slate-200 shadow-inner mb-4 z-0 relative"></div>

                <!-- Hidden Input Coordinates -->
                <div class="grid grid-cols-2 gap-4 hidden">
                    <input type="text" id="latitude" name="latitude" value="{{ old('latitude') }}" readonly required>
                    <input type="text" id="longitude" name="longitude" value="{{ old('longitude') }}" readonly required>
                </div>
            </div>

            <hr class="border-slate-100 mb-8">

            <!-- 2. DETAIL KERUSAKAN -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Nama Fasilitas -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Nama Fasilitas <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_fasilitas" value="{{ old('nama_fasilitas') }}" placeholder="Contoh: Lampu Jalan Dusun 3, Tiang Listrik..." class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition" required>
                    @error('nama_fasilitas') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Spesifikasi/Tingkat Kerusakan (DIUBAH) -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Spesifikasi Kerusakan <span class="text-red-500">*</span></label>
                    <select name="jenis_kerusakan" class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition appearance-none cursor-pointer" required>
                        <option value="" disabled {{ old('jenis_kerusakan') ? '' : 'selected' }}>-- Pilih Tingkat Kerusakan --</option>
                        <option value="Ringan" {{ old('jenis_kerusakan') == 'Ringan' ? 'selected' : '' }}>🟢 Ringan (Kerusakan kecil, masih bisa digunakan)</option>
                        <option value="Sedang" {{ old('jenis_kerusakan') == 'Sedang' ? 'selected' : '' }}>🟡 Sedang (Sebagian fungsi hilang, perlu perbaikan segera)</option>
                        <option value="Berat" {{ old('jenis_kerusakan') == 'Berat' ? 'selected' : '' }}>🔴 Berat (Rusak total, lumpuh, membahayakan warga)</option>
                    </select>
                    @error('jenis_kerusakan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-700 mb-2">Deskripsi Detail <span class="text-red-500">*</span></label>
                <textarea name="deskripsi" rows="3" placeholder="Ceritakan secara detail bagaimana kondisinya..." class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition resize-none" required>{{ old('deskripsi') }}</textarea>
                @error('deskripsi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- 3. FOTO BUKTI -->
            <div class="mb-10">
                <label class="block text-sm font-bold text-slate-700 mb-2">Foto Bukti Kerusakan <span class="text-red-500">*</span></label>
                <div class="flex items-center justify-center w-full">
                    <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-40 border-2 border-slate-300 border-dashed rounded-2xl cursor-pointer bg-slate-50 hover:bg-blue-50 hover:border-blue-300 transition relative overflow-hidden group">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <div class="flex gap-2 mb-3 text-slate-400 group-hover:text-blue-500 transition">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <p class="mb-2 text-sm text-slate-500 font-medium text-center px-4">
                                <span class="font-bold text-blue-600">Ambil Foto Langsung</span> atau Pilih dari Galeri
                            </p>
                            <p class="text-[11px] sm:text-xs text-slate-400">Pastikan foto terlihat jelas (Maks. 4MB)</p>
                        </div>
                        <input id="dropzone-file" type="file" name="foto" accept="image/*" capture="environment" class="hidden" required />
                    </label>
                </div>
                @error('foto') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                
                <!-- Info file terpilih -->
                <div id="file-preview-container" class="mt-3 hidden items-center gap-3 bg-blue-50 p-3 rounded-xl border border-blue-100">
                    <svg class="w-5 h-5 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p id="file-name" class="text-xs sm:text-sm text-blue-700 font-semibold truncate"></p>
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-8 rounded-2xl shadow-lg shadow-blue-500/30 transition transform hover:-translate-y-0.5 text-base sm:text-lg flex justify-center items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                Kirim Laporan Sekarang
            </button>
        </form>
    </div>
</div>

<!-- SCRIPTS UNTUK PETA & SWEETALERT -->
<script>
    // --------------------------------------------------------
    // POP-UP SWEETALERT (Berhasil / Gagal)
    // --------------------------------------------------------
    @if(session('success'))
        Swal.fire({
            title: 'Laporan Terkirim!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonColor: '#2563EB',
            confirmButtonText: 'Kembali ke Dashboard',
            backdrop: `rgba(0,0,123,0.4)`
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('warga.dashboard') }}";
            }
        });
    @endif

    @if($errors->has('lokasi'))
        Swal.fire({
            title: 'Lokasi Tidak Valid',
            text: '{{ $errors->first('lokasi') }}',
            icon: 'error',
            confirmButtonColor: '#EF4444',
            confirmButtonText: 'Pilih Ulang Lokasi'
        });
    @endif

    // --------------------------------------------------------
    // INISIALISASI PETA LEAFLET
    // --------------------------------------------------------
    document.addEventListener("DOMContentLoaded", function() {
        var defaultLat = {{ old('latitude', 3.5952) }};
        var defaultLng = {{ old('longitude', 98.6722) }};
        
        var map = L.map('map').setView([defaultLat, defaultLng], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        var polygonString = {!! $polygonData->geojson ?? 'null' !!};
        
        if (polygonString) {
            var geojsonObj = typeof polygonString === 'string' ? JSON.parse(polygonString) : polygonString;
            var batasDesa = L.geoJSON(geojsonObj, {
                style: { color: "#3B82F6", weight: 3, fillColor: "#93C5FD", fillOpacity: 0.15 }
            }).addTo(map);

            @if(!old('latitude'))
                map.fitBounds(batasDesa.getBounds());
            @endif
        }

        var marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);

        marker.on('dragend', function(e) {
            var position = marker.getLatLng();
            document.getElementById('latitude').value = position.lat.toFixed(7);
            document.getElementById('longitude').value = position.lng.toFixed(7);
        });

        document.getElementById('latitude').value = defaultLat.toFixed(7);
        document.getElementById('longitude').value = defaultLng.toFixed(7);

        window.getLocation = function() {
            if (navigator.geolocation) {
                // Tampilkan loading saat mencari GPS
                Swal.fire({
                    title: 'Mencari Lokasi...',
                    text: 'Pastikan GPS HP Anda menyala.',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading() }
                });

                navigator.geolocation.getCurrentPosition(function(position) {
                    Swal.close(); // Tutup loading
                    var lat = position.coords.latitude;
                    var lng = position.coords.longitude;
                    var newLatLng = new L.LatLng(lat, lng);
                    
                    marker.setLatLng(newLatLng);
                    map.setView(newLatLng, 16);
                    document.getElementById('latitude').value = lat.toFixed(7);
                    document.getElementById('longitude').value = lng.toFixed(7);
                }, function(error) {
                    Swal.fire('Gagal!', 'Akses lokasi ditolak atau tidak tersedia. Aktifkan GPS Anda.', 'warning');
                }, { enableHighAccuracy: true });
            } else {
                Swal.fire('Error', 'Browser tidak mendukung GPS', 'error');
            }
        };

        // UX: Preview File Foto
        document.getElementById('dropzone-file').addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                var fileName = e.target.files[0].name;
                var fileNameDisplay = document.getElementById('file-name');
                var fileContainer = document.getElementById('file-preview-container');
                
                if(fileName.includes('image.')) fileName = "Foto_Kamera_Diambil.jpg";

                fileNameDisplay.textContent = 'Bukti: ' + fileName;
                fileContainer.classList.remove('hidden');
                fileContainer.classList.add('flex');
            }
        });
    });
</script>
@endsection