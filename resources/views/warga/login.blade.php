<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Warga - Pelaporan Fasilitas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .bg-pattern {
            background-color: #f8fafc;
            background-image: radial-gradient(#cbd5e1 1px, transparent 1px);
            background-size: 30px 30px;
        }
    </style>
</head>
<body class="bg-pattern text-slate-800 antialiased min-h-screen flex items-center justify-center p-4">

    <a href="{{ url('/') }}" class="fixed top-6 left-6 flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-blue-600 transition bg-white/80 backdrop-blur px-4 py-2 rounded-full shadow-sm border border-slate-200">
        &larr; Kembali ke Beranda
    </a>

    <div class="bg-white/90 backdrop-blur-xl p-8 sm:p-10 rounded-3xl shadow-2xl border border-slate-100 w-full max-w-md">
        
        <div class="text-center mb-8">
            <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-blue-100 shadow-sm">
                <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            </div>
            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Masuk Sebagai Warga</h2>
            <p class="text-sm text-slate-500 mt-2">Masuk untuk melaporkan fasilitas yang rusak.</p>
        </div>
        
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl mb-6 text-sm flex items-start gap-3">
                <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form action="{{ route('warga.login.submit') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-slate-700 text-sm font-bold mb-2">Alamat Email</label>
                <div class="relative">
                    <input type="email" name="email" class="w-full pl-4 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition" placeholder="email@warga.com" value="{{ old('email') }}" required>
                </div>
            </div>
            
            <div>
                <label class="block text-slate-700 text-sm font-bold mb-2">Kata Sandi</label>
                <div class="relative">
                    <input type="password" name="password" class="w-full pl-4 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition" placeholder="••••••••" required>
                </div>
            </div>
            
            <div class="pt-4">
                <button type="submit" class="w-full flex justify-center items-center gap-2 bg-blue-600 text-white font-bold py-3.5 px-4 rounded-xl shadow-lg shadow-blue-600/30 hover:bg-blue-700 transition transform hover:-translate-y-0.5">
                    Masuk & Lapor Sekarang &rarr;
                </button>
            </div>
        </form>

        <div class="mt-8 text-center text-sm text-slate-500 border-t border-slate-100 pt-6">
            Belum punya akun? Silakan daftar melalui aplikasi mobile.
        </div>

    </div>

</body>
</html>