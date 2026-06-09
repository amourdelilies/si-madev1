<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SI-MADE - Sistem Informasi Desa Mandiri</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    @livewireStyles
</head>
<body class="bg-gray-50 min-h-screen">

    <main class="py-10">
        {{ $slot }}
    </main>

    @livewireScripts
</body>
</html>