<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SI-MADE - Sistem Informasi Manajemen Desa</title>
    <!-- Tailwind CSS & Fonts -->
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
    @livewireStyles
</head>
<body class="bg-slate-50 min-h-screen flex flex-col justify-between">

    <!-- 🟢 NAVBAR / HEADER GLOBAL (TEMA ORANGE-KUNING FILAMENT) -->
    <nav class="bg-white/80 backdrop-blur-md border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                
                <!-- Logo Aplikasi -->
                <a href="/" class="flex items-center gap-2.5 group">
                    <!-- 🟠 PERBAIKAN: Background berganti dari indigo ke amber-500 & orange-600 -->
                    <div class="w-9 h-9 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center text-white font-extrabold shadow-md shadow-orange-100 group-hover:scale-105 transition duration-200">
                        M
                    </div>
                    <div>
                        <span class="text-sm font-black text-gray-800 tracking-tight block">SI-MADE</span>
                        <span class="text-[10px] text-gray-400 font-semibold block -mt-1">Sistem Digitalisasi Manajemen Desa</span>
                    </div>
                </a>

                <!-- Tanggal Statis (Pintu masuk admin sudah disembunyikan agar privat) -->
                <div class="text-[11px] text-amber-700 bg-amber-50 px-3 py-1.5 rounded-xl border border-amber-100 font-bold font-mono hidden sm:block">
                    {{ now()->translatedFormat('l, d F Y') }}
                </div>

            </div>
        </div>
    </nav>

    <!-- 🟢 KONTEN UTAMA -->
    <main class="flex-grow py-6 px-4">
        {{ $slot ?? '' }}
    </main>

    <!-- FOOTER SEDERHANA -->
    <footer class="bg-white border-t border-gray-100 py-4 text-center">
        <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider">
            &copy; 2026 SI-MADE · Sistem Informasi Manajemen Desa 
        </p>
    </footer>

    @livewireScripts
</body>
</html>