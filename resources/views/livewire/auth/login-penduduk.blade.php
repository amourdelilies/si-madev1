<div class="max-w-md mx-auto my-12 p-8 bg-white rounded-2xl shadow-xl border border-gray-100/80">
    
    <!-- Header Formulir Login -->
    <div class="text-center mb-6">
        <div class="inline-flex p-3 bg-indigo-50 text-indigo-600 rounded-2xl mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
            </svg>
        </div>
        <h2 class="text-xl font-bold text-gray-800">Masuk Layanan Mandiri Warga</h2>
        <p class="text-xs text-gray-400 mt-1">Silakan verifikasi identitas Anda menggunakan NIK & Nomor KK</p>
    </div>

    <!-- Notifikasi Umpan Balik / Flash Error -->
    @if (session()->has('error'))
        <div class="mb-5 p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl text-xs font-semibold flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 text-rose-500 shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Tombol Uji Coba Simulasi Instan -->
    <div class="mb-5">
        <button type="button" wire:click="isiDataOtomatis" class="w-full py-2.5 bg-amber-50 hover:bg-amber-100/80 text-amber-800 border border-amber-200/60 rounded-xl text-xs font-bold transition flex items-center justify-center gap-2 cursor-pointer shadow-sm">
            <span>⚡ Isi Data Kredensial Otomatis</span>
        </button>
    </div>

    <!-- Form Input Identitas Kependudukan -->
    <form wire:submit.prevent="login" class="space-y-4">
        <div>
            <label class="block text-xs font-bold text-gray-600 mb-1.5 uppercase tracking-wide">Nomor Induk Kependudukan (NIK)</label>
            <input type="text" wire:model="nik" maxlength="16" placeholder="Masukkan 16 digit NIK" 
                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm font-mono tracking-widest @error('nik') border-red-300 @enderror">
            @error('nik') 
                <span class="text-[10px] text-red-500 mt-1 block font-medium">* {{ $message }}</span> 
            @enderror
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-600 mb-1.5 uppercase tracking-wide">Nomor Kartu Keluarga (KK)</label>
            <input type="password" wire:model="no_kk" maxlength="16" placeholder="Masukkan 16 digit No. KK" 
                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm font-mono tracking-widest @error('no_kk') border-red-300 @enderror">
            @error('no_kk') 
                <span class="text-[10px] text-red-500 mt-1 block font-medium">* {{ $message }}</span> 
            @enderror
        </div>

        <!-- Tombol Aksi Autentikasi -->
        <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-lg shadow-indigo-100 transition duration-150 cursor-pointer mt-4 flex items-center justify-center gap-2">
            <span>Masuk ke Dashboard</span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
            </svg>
        </button>
    </form>

    <!-- Footer Tambahan Akses Cepat Registrasi -->
    <div class="mt-6 text-center border-t border-gray-100 pt-4">
        <p class="text-xs text-gray-500">
            Belum mendaftarkan berkas domisili? 
            <a href="{{ route('registrasi') }}" class="text-indigo-600 font-bold hover:underline ml-0.5">Daftar Mandiri Mandiri</a>
        </p>
    </div>
</div>