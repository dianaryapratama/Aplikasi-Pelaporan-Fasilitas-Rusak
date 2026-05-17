<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - Fasilitas Rusak')</title>

    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#3B82F6">
    <link rel="apple-touch-icon" href="{{ asset('images/icons/icon-192x192.png') }}">
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        
        /* Pattern Background ala Landing Page */
        .bg-pattern {
            background-color: #f1f5f9;
            background-image: radial-gradient(#cbd5e1 1px, transparent 1px);
            background-size: 30px 30px;
        }

        /* Glassmorphism Class */
        .glass-panel {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.05);
        }

        /* Leaflet Map Styling */
        #map { 
            height: 400px; 
            border-radius: 1.5rem; /* rounded-3xl */
            z-index: 10; 
            box-shadow: 0 4px 20px -5px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="bg-pattern text-slate-800 antialiased flex h-screen overflow-hidden selection:bg-blue-200 selection:text-blue-900 relative">
    
    <div id="sidebarOverlay" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-30 hidden transition-opacity md:hidden" onclick="toggleSidebar()"></div>

    <aside id="sidebar" class="glass-panel w-72 flex flex-col fixed inset-y-0 left-0 z-40 my-4 ml-4 rounded-3xl transition-transform duration-300 ease-in-out transform -translate-x-[120%] md:translate-x-0 md:relative">
        
        <div class="p-6 flex items-center gap-3 border-b border-slate-200/60">
            <div class="w-10 h-10 bg-blue-600 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-600/30 shrink-0">
                <span class="text-white font-bold text-xl">F</span>
            </div>
            <span class="font-bold text-xl tracking-tight text-slate-900">Admin Panel</span>
            
            <button onclick="toggleSidebar()" class="ml-auto md:hidden text-slate-400 hover:text-red-500 bg-slate-100 rounded-xl p-1.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl transition font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-600 hover:bg-white hover:shadow-sm' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                Dashboard
            </a>
            <a href="{{ route('admin.setting.index') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl transition font-medium {{ request()->routeIs('admin.setting.index') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-600 hover:bg-white hover:shadow-sm' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                Pengaturan
            </a>
        </nav>

        <div class="p-4 border-t border-slate-200/60">
            <form method="POST" action="{{ url('/logout') }}">
                @csrf
                <button type="submit" class="w-full flex justify-center items-center gap-2 bg-red-50 hover:bg-red-500 text-red-600 hover:text-white py-3 rounded-2xl font-bold transition shadow-sm border border-red-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Keluar (Logout)
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col h-screen overflow-hidden">
        
        <header class="glass-panel mt-4 mr-4 md:ml-4 ml-4 rounded-3xl flex justify-between items-center px-6 py-4 z-10">
            <div class="flex items-center gap-4">
                <button onclick="toggleSidebar()" class="p-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                </button>
                <h2 class="text-xl font-bold text-slate-800 hidden sm:block">
                    @yield('header_title', 'Panel Kontrol')
                </h2>
            </div>
            
            <div class="flex items-center gap-3">
                <div class="text-right hidden sm:block">
                    <p class="text-xs text-slate-500">Selamat datang,</p>
                    <p class="font-bold text-blue-700 leading-tight">{{ Auth::user()->name ?? 'Admin' }}</p>
                </div>
                <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center font-bold border border-blue-200">
                    {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:pr-4 pt-6 pb-24">
            <div class="max-w-7xl mx-auto">
                
                @if(session('success'))
                    <div class="glass-panel border-l-4 border-l-green-500 text-green-700 p-4 mb-6 rounded-2xl flex items-center gap-3 animate-bounce-short">
                        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                @endif

                @yield('content')
                
                <div class="mt-12">
                    @include('layouts.footer')
                </div>
            </div>
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            // Logika untuk Mobile
            if (window.innerWidth < 768) {
                sidebar.classList.toggle('-translate-x-[120%]');
                overlay.classList.toggle('hidden');
            } 
            // Logika untuk Desktop (Mengeser sidebar keluar layar ke kiri)
            else {
                sidebar.classList.toggle('md:translate-x-0');
                sidebar.classList.toggle('md:-translate-x-[120%]');
                sidebar.classList.toggle('md:hidden'); // Sembunyikan elemen agar map bisa melebar penuh
            }
        }

        // Auto close sidebar di mobile jika layar di resize ke desktop
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) {
                document.getElementById('sidebarOverlay').classList.add('hidden');
                document.getElementById('sidebar').classList.remove('-translate-x-[120%]');
                document.getElementById('sidebar').classList.add('md:translate-x-0');
                document.getElementById('sidebar').classList.remove('md:hidden');
            }
        });
    </script>
</body>
</html>