@extends('layouts.app')

@section('title', 'Pengaturan Sistem - Fasilitas Rusak')
@section('header_title', 'Pengaturan Sistem')

@section('content')
<div class="max-w-4xl mx-auto">
    
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-800 leading-tight">Konfigurasi Aplikasi</h2>
        <p class="text-sm text-slate-500">Sesuaikan data instansi, titik pusat peta, dan integrasi pihak ketiga.</p>
    </div>

    <form action="{{ route('admin.setting.update') }}" method="POST" class="space-y-6">
        @csrf
        
        <div class="bg-white/90 backdrop-blur-xl rounded-3xl shadow-sm border border-slate-100 p-8">
            <h3 class="font-bold text-lg mb-6 text-slate-800 flex items-center gap-2 border-b border-slate-100 pb-4">
                <span class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">🏢</span>
                Profil Instansi & Titik Peta
            </h3>
            
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Desa / Instansi</label>
                    <input type="text" name="nama_desa" value="{{ $setting->nama_desa ?? '' }}" class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-4 py-3 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Contoh: Kantor Kepala Desa Suka Maju" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Latitude (Garis Lintang)</label>
                        <input type="text" name="latitude_kantor" value="{{ $setting->latitude_kantor ?? '' }}" class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-4 py-3 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Contoh: 3.5952" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Longitude (Garis Bujur)</label>
                        <input type="text" name="longitude_kantor" value="{{ $setting->longitude_kantor ?? '' }}" class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-4 py-3 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Contoh: 98.6722" required>
                    </div>
                </div>

                <div class="flex items-start gap-3 text-sm text-slate-600 bg-blue-50/50 p-4 rounded-xl border border-blue-100 mt-2">
                    <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shrink-0 mt-0.5 font-bold">!</span>
                    <p class="leading-relaxed">
                        <strong class="text-slate-800">Tips Peta:</strong> Anda bisa mendapatkan nilai Latitude dan Longitude dengan membuka Google Maps, klik kanan pada lokasi kantor desa Anda, lalu klik angka koordinat yang muncul untuk menyalinnya secara otomatis.
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white/90 backdrop-blur-xl rounded-3xl shadow-sm border border-slate-100 p-8">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-6">
                <h3 class="font-bold text-lg text-slate-800 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-sky-100 text-sky-500 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69.01-.03.01-.14-.07-.19-.08-.05-.19-.02-.27 0l-3.2 2.02c-.39.26-.88.35-1.35.22-.55-.15-1.22-.38-1.68-.53-.61-.2-.62-.31-.14-.5 2.37-1.03 3.96-1.7 4.77-2.04 2.27-.96 2.74-1.12 3.05-1.13.07 0 .22.02.3.09.07.06.1.14.1.22 0 .09-.01.19-.02.26z"/></svg>
                    </span>
                    Notifikasi Telegram
                </h3>
                <span class="bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full font-bold">Opsional</span>
            </div>
            
            <div class="space-y-5">
                <p class="text-sm text-slate-600 mb-4">
                    Masukkan API Token Bot dan Chat ID agar setiap ada laporan warga yang baru masuk, sistem akan secara otomatis meneruskan pesan peringatan ke Telegram petugas atau grup desa.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Bot API Token</label>
                        <input type="text" name="telegram_bot_token" value="{{ $setting->telegram_bot_token ?? '' }}" class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-4 py-3 focus:outline-none focus:bg-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition font-mono text-sm" placeholder="Contoh: 123456789:ABCdefGHIjklmNOPqrsTUVwxyz">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Chat ID (Grup / Pribadi)</label>
                        <input type="text" name="telegram_chat_id" value="{{ $setting->telegram_chat_id ?? '' }}" class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-4 py-3 focus:outline-none focus:bg-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition font-mono text-sm" placeholder="Contoh: -1001234567890">
                    </div>
                </div>

                <div class="flex items-start gap-3 text-sm text-slate-600 bg-slate-50 p-4 rounded-xl border border-slate-200 mt-2">
                    <span class="w-6 h-6 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center shrink-0 mt-0.5 font-bold">?</span>
                    <ul class="list-disc pl-4 space-y-1">
                        <li>Dapatkan <strong>Bot API Token</strong> dengan membuat bot baru melalui <a href="https://t.me/BotFather" target="_blank" class="text-sky-600 hover:underline">@BotFather</a> di Telegram.</li>
                        <li>Dapatkan <strong>Chat ID</strong> grup/pribadi Anda dengan menambahkan <a href="https://t.me/userinfobot" target="_blank" class="text-sky-600 hover:underline">@userinfobot</a> atau IDBot lainnya. Jangan lupa masukkan bot Anda ke dalam grup agar bot bisa mengirim pesan.</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-8 rounded-xl shadow-lg shadow-blue-600/30 transition transform hover:-translate-y-0.5 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                Simpan Semua Pengaturan
            </button>
        </div>

    </form>
</div>
@endsection