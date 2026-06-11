<div class="max-w-md mx-auto my-10 p-8 bg-white rounded-xl shadow-md border border-gray-100">
    
    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-xl flex flex-col justify-between gap-3 shadow-sm">
        <div class="flex space-x-2">
            <span class="text-xl">⚡</span>
            <div>
                <p class="text-xs font-bold text-blue-800">Uji Coba Login?</p>
                <p class="text-[11px] text-blue-600">Gunakan fitur ini untuk mengisi NIK (Username) dan No KK (Password) secara instan saat testing.</p>
            </div>
        </div>
        <button type="button" wire:click="isiDataOtomatis" class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg shadow transition active:scale-95 cursor-pointer">
            Isi Akun Testing
        </button>
    </div>

    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-800">Masuk Layanan (SI-MADE)</h2>
        <p class="text-gray-500 text-sm mt-1">Silakan masukkan NIK dan Nomor KK Anda untuk mengakses dashboard penduduk mandiri.</p>
    </div>

    @if (session()->has('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent="login" class="space-y-5">
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">NIK (16 Digit) <span class="text-red-500">*</span></label>
            <input type="text" wire:model="nik" required maxlength="16" placeholder="Masukkan 16 digit NIK Anda" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
            @error('nik') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Kartu Keluarga (Password) <span class="text-red-500">*</span></label>
            <input type="password" wire:model="no_kk" required maxlength="16" placeholder="Masukkan 16 digit Nomor KK" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
            @error('no_kk') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div class="text-sm text-right">
            <span class="text-gray-500">Belum terdaftar?</span>
            <a href="{{ route('registrasi') }}" wire:navigate class="font-medium text-indigo-600 hover:text-indigo-500">Daftar Mandiri</a>
        </div>

        <div>
            <button type="submit" class="w-full px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg text-sm shadow-sm transition duration-150 cursor-pointer">
                Masuk ke Aplikasi
            </button>
        </div>
    </form>
</div>