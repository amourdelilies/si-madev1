<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard Penduduk SI-MADE' }}</title>
    
    <!-- Menggunakan CDN Tailwind CSS agar visualnya langsung rapi dan instan -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 antialiased">
    <nav class="bg-blue-600 p-4 text-white shadow-md">
        <div class="max-w-4xl mx-auto flex justify-between items-center">
            <span class="font-bold text-lg tracking-wider">SI-MADE DIGI</span>
            <span class="text-sm opacity-90">Layanan Mandiri Desa</span>
        </div>
    </nav>

    <main class="py-6">
        <!--  Slot inilah yang bertugas menangkap dan menampilkan isi dari dashboard-penduduk.blade.php -->
        {{ $slot }}
    </main>
</body>
</html>
