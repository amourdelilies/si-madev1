<div class="max-w-5xl mx-auto my-4 bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden min-h-[580px] grid grid-cols-1 md:grid-cols-12">
    
    <!-- 🟠 SECTION KIRI: SPANDUK INFORMASI LAYANAN (SPLIT BANNER) -->
    <div class="md:col-span-5 bg-gradient-to-br from-amber-500 via-orange-500 to-red-600 p-8 md:p-10 text-white flex flex-col justify-between relative overflow-hidden">
        <!-- Dekorasi Pola Dot Minimalis -->
        <div class="absolute top-4 left-4 opacity-10">
            <svg width="60" height="60" viewBox="0 0 20 20" fill="currentColor"><circle cx="2" cy="2" r="2"/><circle cx="8" cy="2" r="2"/><circle cx="14" cy="2" r="2"/><circle cx="2" cy="8" r="2"/><circle cx="8" cy="8" r="2"/><circle cx="14" cy="8" r="2"/><circle cx="2" cy="14" r="2"/><circle cx="8" cy="14" r="2"/><circle cx="14" cy="14" r="2"/></svg>
        </div>

        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 backdrop-blur-md rounded-full text-[10px] font-bold tracking-wider uppercase mb-8">
                ✨ Portal Mandiri Warga
            </div>
            <h2 class="text-2xl md:text-3xl font-black tracking-tight leading-tight mb-2">Layanan Digital Swadaya Desa</h2>
            <p class="text-xs text-amber-50/80 leading-relaxed">Nikmati kemudahan pengurusan administrasi, pelaporan, dan kontribusi sosial dalam satu genggaman tangan.</p>
        </div>

        <!-- Daftar Fitur Unggulan -->
        <div class="space-y-4 my-8 md:my-0">
            <div class="flex items-center gap-3 text-xs font-semibold bg-white/5 p-2.5 rounded-xl border border-white/10 backdrop-blur-sm">
                <span class="w-6 h-6 rounded-lg bg-amber-400 text-amber-950 flex items-center justify-center font-bold text-[10px]">01</span>
                <span>Pengajuan Surat Resmi Otomatis</span>
            </div>
            <div class="flex items-center gap-3 text-xs font-semibold bg-white/5 p-2.5 rounded-xl border border-white/10 backdrop-blur-sm">
                <span class="w-6 h-6 rounded-lg bg-orange-400 text-orange-950 flex items-center justify-center font-bold text-[10px]">02</span>
                <span>Aduan & Aspirasi Real-Time</span>
            </div>
            <div class="flex items-center gap-3 text-xs font-semibold bg-white/5 p-2.5 rounded-xl border border-white/10 backdrop-blur-sm">
                <span class="w-6 h-6 rounded-lg bg-yellow-400 text-yellow-950 flex items-center justify-center font-bold text-[10px]">03</span>
                <span>Kontribusi Lumbung Gotong Royong</span>
            </div>
        </div>

        <div class="text-[10px] text-amber-100/60 font-medium">
            Membangun Desa Digital Swadaya Terintegrasi · SI-MADE
        </div>
    </div>

    <!-- ⚪ SECTION KANAN: FORMULIR UTAMA UTK AUTENTIKASI -->
    <div class="md:col-span-7 p-8 md:p-12 flex flex-col justify-center bg-white">
        
        <!-- Header Form -->
        <div class="mb-6">
            <h3 class="text-xl font-extrabold text-gray-800 tracking-tight">Selamat Datang!</h3>
            <p class="text-xs text-gray-400 mt-1">Silakan verifikasi identitas kependudukan Anda untuk masuk ke sistem</p>
        </div>

        <!-- Notifikasi Umpan Balik / Flash Error -->
        @if (session()->has('error'))
            <div class="mb-5 p-4 bg-rose-50 border border-rose-100 text-rose-700 rounded-xl text-xs font-semibold flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 text-rose-500 shrink-0">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

    

        <!-- Form Input Identitas Kependudukan -->
        <form wire:submit.prevent="login" class="space-y-4">
            <div>
                <label class="block text-[10px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Nomor Induk Kependudukan (NIK)</label>
                <!-- 🟢 PERBAIKAN: Menggunakan .blur agar performa ketikan lancar tanpa lag server -->
                <input type="text" wire:model.blur="nik" maxlength="16" placeholder="Masukkan 16 digit NIK" 
                    class="w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm font-mono tracking-widest @error('nik') border-red-300 @enderror">
                @error('nik') 
                    <span class="text-[10px] text-red-500 mt-1 block font-medium">* {{ $message }}</span> 
                @enderror
            </div>

            <div>
                <label class="block text-[10px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Nomor Kartu Keluarga (KK)</label>
                <!-- 🟢 PERBAIKAN: Menggunakan .blur -->
                <input type="password" wire:model.blur="no_kk" maxlength="16" placeholder="Masukkan 16 digit No. KK" 
                    class="w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm font-mono tracking-widest @error('no_kk') border-red-300 @enderror">
                @error('no_kk') 
                    <span class="text-[10px] text-red-500 mt-1 block font-medium">* {{ $message }}</span> 
                @enderror
            </div>

            <!-- Tombol Submit (Gradasi Orange-Amber Filament) -->
            <!-- 🟢 PERBAIKAN: Ditambahkan status loading dan pencegahan double-click -->
            <button type="submit" wire:loading.attr="disabled" class="w-full py-3 bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white rounded-xl text-xs font-bold shadow-md shadow-orange-100 transition duration-150 cursor-pointer mt-4 flex items-center justify-center gap-2 disabled:opacity-60 disabled:cursor-not-allowed">
                <span wire:loading.remove>Masuk Ke Dashboard</span>
                <span wire:loading>Memvalidasi Identitas...</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                </svg>
            </button>
        </form>

        <!-- Footer Registrasi Mandiri -->
        <div class="mt-6 text-center border-t border-gray-100 pt-4">
            <p class="text-xs text-gray-400">
                Belum mendaftarkan berkas domisili? 
                <!-- 🟢 PERBAIKAN: Teks typo berulang 'Mandiri Mandiri' sudah dibersihkan -->
                <a href="{{ route('registrasi') }}" class="text-orange-600 font-extrabold hover:underline ml-0.5">Daftar Mandiri</a>
            </p>
        </div>
    </div>
</div>