<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-Layanan Desa | Aplikasi Pelaporan Fasilitas Rusak</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .bg-pattern {
            background-color: #f8fafc;
            background-image: radial-gradient(#cbd5e1 1px, transparent 1px);
            background-size: 30px 30px;
        }
        /* Animasi mengambang untuk mockup */
        .animate-float { animation: float 6s ease-in-out infinite; }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
    </style>
</head>
<body class="bg-pattern text-slate-800 antialiased selection:bg-blue-200 selection:text-blue-900">

    <!-- NAVBAR -->
    <nav class="fixed w-full bg-white/90 backdrop-blur-md border-b border-slate-200 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 or 20 items-center">
                <!-- Logo -->
                <div class="flex items-center gap-2 sm:gap-3 cursor-pointer" onclick="window.scrollTo(0,0)">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-blue-600 to-blue-500 rounded-lg flex items-center justify-center shadow-lg shadow-blue-500/30">
                        <span class="text-white font-bold text-lg">F</span>
                    </div>
                    <span class="font-extrabold text-lg sm:text-xl tracking-tight text-slate-900 hidden sm:block">SIG <span class="text-blue-600">Fasilitas</span></span>
                </div>

                <!-- Menu Navigasi Tengah -->
                <div class="hidden lg:flex items-center gap-8 font-semibold text-sm text-slate-600">
                    <a href="#beranda" class="hover:text-blue-600 transition">Beranda</a>
                    <a href="#fitur" class="hover:text-blue-600 transition">Fitur Keunggulan</a>
                    <a href="#tentang" class="hover:text-blue-600 transition">Cara Lapor</a>
                    <a href="#pengembang" class="hover:text-blue-600 transition">Pengembang</a>
                </div>

                <!-- Tombol Auth -->
                <div>
                    @if (Route::has('login'))
                        @auth
                            @if (Auth::user()->role === 'admin')
                                <a href="{{ url('/admin/dashboard') }}" class="text-sm font-bold text-white bg-slate-900 px-5 py-2.5 rounded-xl hover:bg-slate-800 transition shadow-md">Buka Dashboard &rarr;</a>
                            @else
                                <a href="{{ route('warga.dashboard') }}" class="text-sm font-bold text-white bg-blue-600 px-5 py-2.5 rounded-xl hover:bg-blue-700 transition shadow-md shadow-blue-500/30">Dashboard Saya &rarr;</a>
                            @endif
                        @else
                            <div class="flex items-center gap-2 sm:gap-4">
                                <a href="{{ route('login') }}" class="text-sm font-bold text-slate-700 hover:text-blue-600 px-2 sm:px-4 py-2 transition hidden sm:block">Login</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('warga.login') }}" class="text-xs sm:text-sm font-bold text-white bg-blue-600 px-4 sm:px-6 py-2.5 rounded-xl hover:bg-blue-700 transition shadow-md shadow-blue-500/30">Portal Warga</a>
                                @endif
                            </div>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION DENGAN BACKGROUND STRATEGIS -->
<section id="beranda" class="relative pt-32 pb-16 lg:pt-40 lg:pb-24 overflow-hidden bg-cover bg-center bg-no-repeat" 
    style="background-image: url('https://images.unsplash.com/photo-1596422846543-75c6fc197f07?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');">
    
    <!-- Overlay Gradasi: Menjamin teks tetap terbaca (Readable) -->
    <div class="absolute inset-0 bg-white/90 lg:bg-gradient-to-r lg:from-white/100 lg:via-white/80 lg:to-transparent z-0"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-8 items-center">
            
            <!-- Kiri: Teks & Tombol -->
            <div class="text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-50 border border-blue-200 text-blue-700 text-xs sm:text-sm font-bold mb-6 shadow-sm">
                    <span class="flex h-2.5 w-2.5 rounded-full bg-blue-600 animate-pulse"></span>
                    Pelayanan Desa Terintegrasi SIG
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight text-slate-900 mb-6 leading-[1.15]">
                    Lapor Kerusakan Fasilitas <br class="hidden lg:block"> 
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500">Lebih Cepat & Akurat</span>
                </h1>
                <p class="text-lg text-slate-700 mb-8 leading-relaxed max-w-xl mx-auto lg:mx-0 font-medium">
                    Jangan biarkan jalan berlubang atau lampu mati membahayakan warga. Gunakan aplikasi ini untuk memetakan kerusakan secara *real-time* langsung dari HP Anda.
                </p>

                <div class="flex flex-col sm:flex-row justify-center lg:justify-start gap-4">
                     <a href="{{ route('warga.login') }}" class="inline-flex justify-center items-center gap-2 rounded-xl bg-blue-600 px-8 py-4 text-base font-bold text-white shadow-lg shadow-blue-500/30 hover:bg-blue-700 transition transform hover:-translate-y-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        Buat Laporan Sekarang
                    </a>
                    <button id="btnInstallApp" class="inline-flex justify-center items-center gap-2 bg-white text-slate-700 border-2 border-slate-200 font-bold py-4 px-8 rounded-xl shadow-sm hover:bg-slate-50 hover:border-slate-300 transition">
                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 24 24"><path d="M17.523 15.3414c-.0522 1.0963.9538 1.5036.9854 1.5173-.0105.0345-.1527.5262-.5114 1.0713-.3215.4854-.662 1.0366-1.206 1.0504-.5335.0136-.7134-.3138-1.3323-.3138-.619 0-.829.3002-1.3324.3275-.5335.0272-.829-.4648-1.206-1.009-.4345-.6274-.8342-1.691-.403-2.4412.2146-.3818.5758-.6274.9682-.641 1.0664.068 1.7144.3818 2.0645.3818-.0892-.0954-1.1293-1.0772-1.077-2.1544.0264-.518.2356-1.009.6125-1.377.3402-.3274.7904-.5456 1.2562-.6138 1.0664-.15 1.7824.5727 1.7824.5727-.0892.0136.6335-.8046 1.638-.859 1.0048-.0546 1.8373.5726 1.8373.5726zM15.449 9.381c.2146-.4363.3402-1.0363.2983-1.5954-.424.0818-1.084.341-1.508.7636-.3558.3546-.6568.968-.5835 1.5408.4972.109 1.0835-.2045 1.7932-.709z"/></svg>
                        Install Aplikasi Mobile
                    </button>
                </div>
            </div>

            <!-- Kanan: Visual Mockup (Tetap tampil sebagai elemen interaktif) -->
            <div class="hidden lg:block relative animate-float">
                <div class="relative w-full max-w-lg mx-auto">
                    <!-- Kotak Peta -->
                    <div class="bg-white p-2 rounded-3xl shadow-2xl border-4 border-slate-100 overflow-hidden relative">
                        <div class="w-full h-80 bg-blue-50 rounded-2xl relative overflow-hidden flex items-center justify-center">
                            <div class="absolute inset-0 opacity-20" style="background-image: repeating-linear-gradient(#475569 1px, transparent 1px), repeating-linear-gradient(90deg, #475569 1px, transparent 1px); background-size: 40px 40px;"></div>
                            <div class="relative z-10 text-red-500 mb-8 animate-bounce">
                                <svg class="w-16 h-16 drop-shadow-lg" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                            </div>
                        </div>
                    </div>
                    <!-- Notifikasi Melayang -->
                    <div class="absolute -left-12 top-20 bg-white p-4 rounded-2xl shadow-xl border border-slate-100 flex items-center gap-4">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></div>
                        <div>
                            <p class="text-sm font-bold text-slate-800">Laporan Selesai</p>
                            <p class="text-xs text-slate-500 font-medium">Jalan Berlubang Dusun 3</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

    <!-- TRUST & STATS BANNER -->
    <div class="bg-blue-600 border-y border-blue-700 py-6">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 flex flex-col sm:flex-row justify-around items-center gap-6 text-white text-center sm:text-left divide-y sm:divide-y-0 sm:divide-x divide-blue-500">
            <div class="w-full sm:w-1/3 pt-4 sm:pt-0 sm:px-6 flex flex-col items-center sm:items-start">
                <span class="text-3xl font-black mb-1">100%</span>
                <span class="text-blue-200 text-sm font-medium">Transparansi Laporan</span>
            </div>
            <div class="w-full sm:w-1/3 pt-4 sm:pt-0 sm:px-6 flex flex-col items-center sm:items-start">
                <span class="text-3xl font-black mb-1">24/7</span>
                <span class="text-blue-200 text-sm font-medium">Akses Portal Pengaduan</span>
            </div>
            <div class="w-full sm:w-1/3 pt-4 sm:pt-0 sm:px-6 flex flex-col items-center sm:items-start">
                <span class="text-3xl font-black mb-1">GPS</span>
                <span class="text-blue-200 text-sm font-medium">Pemetaan Titik Real-time</span>
            </div>
        </div>
    </div>

    <!-- FITUR KEUNGGULAN (NEW SECTION) -->
    <section id="fitur" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-blue-600 font-bold tracking-wide uppercase text-sm mb-2">Mengapa Platform Ini Dibuat?</h2>
                <h3 class="text-3xl md:text-4xl font-extrabold text-slate-900">Solusi Pintar untuk Warga Desa</h3>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Fitur 1 -->
                <div class="bg-slate-50 p-8 rounded-3xl border border-slate-100">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-800 mb-3">Respon Lebih Cepat</h4>
                    <p class="text-slate-600 text-sm leading-relaxed">Admin desa langsung menerima notifikasi Telegram saat Anda melapor. Tidak perlu lagi birokrasi kertas yang panjang dan rumit.</p>
                </div>
                <!-- Fitur 2 -->
                <div class="bg-slate-50 p-8 rounded-3xl border border-slate-100">
                    <div class="w-12 h-12 bg-orange-100 text-orange-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-800 mb-3">Pantau Prosesnya</h4>
                    <p class="text-slate-600 text-sm leading-relaxed">Tersedia Dashboard Warga khusus untuk memantau apakah laporan Anda masih <i>Menunggu</i>, <i>Diproses</i>, atau sudah <i>Selesai</i> diperbaiki.</p>
                </div>
                <!-- Fitur 3 -->
                <div class="bg-slate-50 p-8 rounded-3xl border border-slate-100">
                    <div class="w-12 h-12 bg-green-100 text-green-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-800 mb-3">Presisi Koordinat Peta</h4>
                    <p class="text-slate-600 text-sm leading-relaxed">Sistem terintegrasi dengan PostGIS untuk memastikan pelapor wajib berada di dalam batas wilayah desa, mencegah laporan palsu/hoaks.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CARA KERJA -->
    <section id="tentang" class="py-20 bg-slate-50 border-y border-slate-200">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-slate-900 mb-4">Cara Kerja Semudah Kirim Pesan</h2>
                <p class="text-slate-600 max-w-2xl mx-auto">Kami menyederhanakan alur pelaporan teknis menjadi 3 langkah mudah yang bisa dilakukan oleh siapa saja.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-10 relative">
                <!-- Garis Penghubung (Hanya Desktop) -->
                <div class="hidden md:block absolute top-1/2 left-[15%] right-[15%] h-1 bg-slate-200 -translate-y-1/2 z-0"></div>

                <!-- Step 1 -->
                <div class="relative z-10 text-center flex flex-col items-center">
                    <div class="w-16 h-16 bg-white border-4 border-blue-500 rounded-full flex items-center justify-center text-blue-600 font-bold text-xl mb-6 shadow-lg">1</div>
                    <h3 class="font-bold text-xl text-slate-900 mb-3">Foto & Tandai Lokasi</h3>
                    <p class="text-slate-600 text-sm leading-relaxed max-w-xs">Buka aplikasi, aktifkan GPS, foto fasilitas yang rusak, dan pilih tingkat keparahannya (Ringan/Sedang/Berat).</p>
                </div>
                
                <!-- Step 2 -->
                <div class="relative z-10 text-center flex flex-col items-center">
                    <div class="w-16 h-16 bg-white border-4 border-orange-500 rounded-full flex items-center justify-center text-orange-600 font-bold text-xl mb-6 shadow-lg">2</div>
                    <h3 class="font-bold text-xl text-slate-900 mb-3">Tim Desa Menerima</h3>
                    <p class="text-slate-600 text-sm leading-relaxed max-w-xs">Admin desa menerima notifikasi beserta peta rute. Laporan diverifikasi dan statusnya diubah menjadi "Proses".</p>
                </div>
                
                <!-- Step 3 -->
                <div class="relative z-10 text-center flex flex-col items-center">
                    <div class="w-16 h-16 bg-white border-4 border-green-500 rounded-full flex items-center justify-center text-green-600 font-bold text-xl mb-6 shadow-lg">3</div>
                    <h3 class="font-bold text-xl text-slate-900 mb-3">Selesai Diperbaiki</h3>
                    <p class="text-slate-600 text-sm leading-relaxed max-w-xs">Tim teknisi lapangan menyelesaikan perbaikan. Status di dasbor Anda akan berubah menjadi hijau (Selesai).</p>
                </div>
            </div>
        </div>
    </section>

    <!-- TEKNOLOGI -->
    <section id="teknologi" class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <p class="text-center text-xs font-bold text-slate-400 uppercase tracking-widest mb-6">Dibangun dengan Teknologi Mutakhir</p>
            <div class="flex flex-wrap justify-center items-center gap-8 md:gap-16 opacity-60 grayscale hover:grayscale-0 transition duration-500">
                <div class="flex flex-col items-center gap-1 group">
                    <svg class="w-10 h-10 text-[#FF2D20]" viewBox="0 0 24 24" fill="currentColor"><path d="M22.043 10.648v.002l-1.42 2.155-2.28-1.503-4.832 7.575-3.327-8.156-6.666 9.42-.821-3.666L11.53 4l3.197 7.824 4.394-6.883 2.922 5.707z"/></svg>
                    <span class="text-[10px] font-bold text-slate-500">Laravel 11+</span>
                </div>
                <div class="flex flex-col items-center gap-1 group">
                    <svg class="w-10 h-10 text-[#02569B]" viewBox="0 0 24 24" fill="currentColor"><path d="M14.314 0L2.3 12 6 15.7 21.684.013h-7.357zm.014 11.072L7.857 17.53l3.67 3.67 9.03-8.98H14.33zm-4.597 4.596L6.03 19.35l2.457 2.458a1.53 1.53 0 002.164 0l2.766-2.766-3.686-3.374z"/></svg>
                    <span class="text-[10px] font-bold text-slate-500">Flutter</span>
                </div>
                <div class="flex flex-col items-center gap-1 group">
                    <svg class="w-10 h-10 text-[#336791]" viewBox="0 0 24 24" fill="currentColor"><path d="M21.144 14.195c-.328 2.012-2.144 3.32-4.225 3.32h-3.41v2.308c0 .878-.713 1.59-1.59 1.59h-2.31c-.877 0-1.59-.712-1.59-1.59v-2.308H4.61c-2.08 0-3.896-1.308-4.224-3.32C-.035 11.643.084 8.742 1.48 6.45c1.196-1.968 3.31-3.15 5.59-3.15h1.168c.84-.875 2.03-1.424 3.344-1.424 1.313 0 2.503.549 3.343 1.424h1.168c2.28 0 4.394 1.182 5.59 3.15 1.396 2.293 1.515 5.194 1.05 7.745zM11.58 4.606c-.846 0-1.534.688-1.534 1.534 0 .847.688 1.534 1.535 1.534.846 0 1.533-.687 1.533-1.534 0-.846-.687-1.534-1.533-1.534zm3.924 5.378H7.656v3.085h7.848V9.984z"/></svg>
                    <span class="text-[10px] font-bold text-slate-500">PostGIS</span>
                </div>
                <div class="flex flex-col items-center gap-1 group">
                    <svg class="w-10 h-10 text-[#06B6D4]" viewBox="0 0 24 24" fill="currentColor"><path d="M12.001 4.8c-3.2 0-5.2 1.6-6 4.8 1.2-1.6 2.6-2.2 4.2-1.8.913.228 1.565.89 2.288 1.624C13.666 10.618 15.027 12 18.001 12c3.2 0 5.2-1.6 6-4.8-1.2 1.6-2.6 2.2-4.2 1.8-.913-.228-1.565-.89-2.288-1.624C16.337 6.182 14.976 4.8 12.001 4.8zm-6 7.2c-3.2 0-5.2 1.6-6 4.8 1.2-1.6 2.6-2.2 4.2-1.8.913.228 1.565.89 2.288 1.624 1.177 1.194 2.538 2.576 5.512 2.576 3.2 0 5.2-1.6 6-4.8-1.2 1.6-2.6 2.2-4.2 1.8-.913-.228-1.565-.89-2.288-1.624C10.337 13.382 8.976 12 6.001 12z"/></svg>
                    <span class="text-[10px] font-bold text-slate-500">Tailwind</span>
                </div>
            </div>
        </div>
    </section>

    <!-- PENGEMBANG -->
    <section id="pengembang" class="py-20 relative bg-slate-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="bg-gradient-to-br from-slate-900 to-blue-950 rounded-3xl p-8 md:p-12 text-white shadow-2xl relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-20 -mr-20 w-80 h-80 bg-blue-500 opacity-20 rounded-full blur-3xl"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row items-center gap-10">
                    <div class="md:w-2/3">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-800/50 border border-blue-700 text-blue-200 text-xs font-bold uppercase tracking-wider mb-4">
                            Latar Belakang Proyek
                        </div>
                        <h2 class="text-3xl font-bold mb-4">Dikembangkan Oleh Mahasiswa</h2>
                        <p class="text-blue-100 mb-6 leading-relaxed text-lg">
                            Platform Sistem Informasi Geografis (SIG) ini dirancang sebagai solusi *Smart Village* untuk memfasilitasi pemetaan partisipatif masyarakat. Tujuannya adalah membantu pemerintah desa merespon kerusakan fasilitas secara lebih presisi.
                        </p>
                        <div class="bg-white/10 backdrop-blur-md border border-white/20 p-5 rounded-xl inline-block">
                            <p class="text-xs text-blue-300 uppercase tracking-wider mb-1 font-semibold">Lead Engineer & Peneliti</p>
                            <p class="text-xl font-bold text-white flex items-center gap-2">Dian Arya Pratama</p>
                            <p class="text-sm text-blue-200 mt-2">Teknologi Rekayasa Perangkat Lunak (TRPL-6B)<br>Politeknik Negeri Medan</p>
                        </div>
                    </div>
                    <div class="md:w-1/3 w-full text-center bg-white/5 backdrop-blur border border-white/10 p-8 rounded-2xl" id="download">
                        <div class="bg-blue-600 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        </div>
                        <h3 class="font-bold text-lg mb-1">Aplikasi Warga (Mobile)</h3>
                        <p class="text-xs text-blue-200 mb-6">Versi 1.0.0 (Android APK)</p>
                        <a href="#" class="w-full block text-center rounded-xl bg-white text-blue-900 font-bold py-3 shadow-lg hover:bg-slate-100 transition transform hover:-translate-y-1">
                            Unduh Aplikasi Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-slate-900 text-slate-300 pt-16 pb-8 border-t-[6px] border-blue-600">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
                <div class="lg:col-span-1">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                            <span class="text-white font-bold text-lg">F</span>
                        </div>
                        <span class="font-bold text-white text-xl tracking-wide">SIG <span class="text-blue-500">Fasilitas</span></span>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed mb-6">Mengintegrasikan data keruangan dan keluhan warga dalam satu platform Sistem Informasi Geografis modern.</p>
                </div>
                <div>
                    <h3 class="text-white font-semibold text-lg mb-6 flex items-center gap-2"><span class="w-1 h-5 bg-blue-500 rounded-full"></span> Bantuan Warga</h3>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#" class="hover:text-blue-400 transition">&rarr; Cara Membuat Akun</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition">&rarr; Panduan Menyalakan GPS</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition">&rarr; Syarat & Ketentuan Lapor</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-white font-semibold text-lg mb-6 flex items-center gap-2"><span class="w-1 h-5 bg-blue-500 rounded-full"></span> Tautan Sistem</h3>
                    <ul class="space-y-3 text-sm">
                        <li><a href="{{ route('warga.login') }}" class="hover:text-blue-400 transition">&rarr; Portal Warga (Lapor)</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-blue-400 transition">&rarr; Login Admin Desa</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-white font-semibold text-lg mb-6 flex items-center gap-2"><span class="w-1 h-5 bg-blue-500 rounded-full"></span> Hubungi Kami</h3>
                    <ul class="space-y-4 text-sm text-slate-400">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                            <span>Politeknik Negeri Medan<br>Sumatera Utara, Indonesia</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <span><a href="mailto:dianarya@email.com" class="hover:text-blue-400 transition">dianarya@email.com</a></span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-slate-500">
                <p>&copy; {{ date('Y') }} Platform SIG Pelaporan Desa. All rights reserved.</p>
                <p>Developed with <span class="text-red-500">&hearts;</span> by Dian Arya Pratama</p>
            </div>
        </div>
    </footer>

    <!-- SCRIPT PWA & INTERAKTIF -->
    <script>
        // Efek Navbar transparan saat di-scroll
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('nav');
            if (window.scrollY > 20) {
                nav.classList.add('shadow-sm', 'bg-white/95');
                nav.classList.remove('bg-white/90');
            } else {
                nav.classList.remove('shadow-sm', 'bg-white/95');
                nav.classList.add('bg-white/90');
            }
        });

        // Logika PWA (Install Button)
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js').catch(() => {});
            });
        }

        let deferredPrompt;
        const installBtn = document.getElementById('btnInstallApp');

        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
        });

        if (installBtn) {
            installBtn.addEventListener('click', async () => {
                const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
                if (isIOS) {
                    alert("🍎 Untuk iPhone/iPad:\n1. Tekan tombol 'Share' di bawah.\n2. Pilih 'Add to Home Screen'.");
                    return;
                }
                if (deferredPrompt) {
                    deferredPrompt.pr     ompt();
                    const { outcome } = await deferredPrompt.userChoice;
                    deferredPrompt = null;
                } else {
                    alert("Aplikasi sudah terinstal, atau browser Anda harus di-update.");
                }
            });
        }
    </script>
</body>
</html>