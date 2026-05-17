<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Warga - e-Layanan Desa')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased flex h-screen overflow-hidden">

    <!-- OVERLAY GELAP UNTUK MOBILE (Klik untuk menutup sidebar) -->
    <div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-900/50 z-20 hidden transition-opacity duration-300 md:hidden"></div>

    <!-- SIDEBAR -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 w-64 bg-white border-r border-slate-200 flex flex-col z-30 transform -translate-x-full transition-transform duration-300 ease-in-out md:relative md:translate-x-0">
        <!-- Logo Area -->
        <div class="h-16 flex items-center justify-between px-6 border-b border-slate-100">
            <span class="text-xl font-black text-blue-600 tracking-tight">steamtek<span class="text-slate-800">.id</span></span>
            <!-- Tombol Tutup Khusus Mobile -->
            <button onclick="toggleSidebar()" class="md:hidden text-slate-400 hover:text-red-500 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Menu Navigasi -->
        <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-2">
            <p class="px-2 text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-2">Menu Utama</p>
            
            <a href="{{ route('warga.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition {{ request()->routeIs('warga.dashboard') ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50 hover:text-blue-600' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Dashboard Saya
            </a>

            <a href="{{ url('/lapor') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition text-slate-600 hover:bg-slate-50 hover:text-blue-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                Buat Laporan Baru
            </a>
        </nav>

        <!-- Bagian Bawah Sidebar (Logout) -->
        <div class="p-4 border-t border-slate-100">
            <form method="POST" action="{{ url('/logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-red-50 text-red-600 hover:bg-red-100 rounded-xl font-bold transition text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Keluar (Logout)
                </button>
            </form>
        </div>
    </aside>

    <!-- AREA KONTEN UTAMA -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden w-full">
        
        <!-- TOPBAR -->
        <header class="h-16 bg-white/80 backdrop-blur-md border-b border-slate-200 flex items-center justify-between px-4 sm:px-6 z-10 shrink-0">
            
            <div class="flex items-center gap-3">
                <!-- Tombol Hamburger Mobile -->
                <button onclick="toggleSidebar()" class="md:hidden p-2 -ml-2 text-slate-600 hover:text-blue-600 transition rounded-lg hover:bg-slate-100 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                </button>
                <div class="font-bold text-slate-700 text-lg sm:text-base hidden sm:block">
                    Portal Warga
                </div>
            </div>

            <!-- Info Profil -->
            <div class="flex items-center gap-3">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-bold text-slate-800 leading-none">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-slate-500 mt-1">Warga Desa</p>
                </div>
                <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold border-2 border-blue-200 shadow-sm text-sm sm:text-base">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </div>
        </header>

        <!-- KONTEN DINAMIS -->
        <main class="flex-1 overflow-y-auto p-4 sm:p-8 bg-slate-50 w-full relative">
            @yield('content')
        </main>
        
    </div>

    <!-- SCRIPT UNTUK TOGGLE SIDEBAR MOBILE -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            // Toggle posisi X sidebar
            sidebar.classList.toggle('-translate-x-full');
            
            // Toggle overlay gelap
            overlay.classList.toggle('hidden');
        }
    </script>
</body>
</html>