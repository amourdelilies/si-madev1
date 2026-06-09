<div class="max-w-4xl mx-auto my-10 p-8 bg-white rounded-xl shadow-md border border-gray-100">
    
    <!-- 🌟 TOMBOL PENYELAMAT: Klik ini agar data langsung terisi otomatis tanpa ketik manual -->
    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-xl flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 shadow-sm">
        <div class="flex items-center space-x-2">
            <span class="text-xl">⚡</span>
            <div>
                <p class="text-xs font-bold text-blue-800">Cape Buat Data Mulu?</p>
                <p class="text-[11px] text-blue-600">Klik tombol di sebelah kanan untuk mengisi semua form secara instan dengan NIK acak!</p>
            </div>
        </div>
        <button type="button" wire:click="isiDataOtomatis" class="w-full sm:w-auto px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg shadow transition active:scale-95 cursor-pointer">
            Isi Data Otomatis
        </button>
    </div>

    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-800">Pendaftaran Penduduk Mandiri (SI-MADE)</h2>
        <p class="text-gray-500 text-sm mt-1">Isi data diri dan unggah berkas resmi Anda untuk aktivasi layanan surat digital tanpa ke kantor desa.</p>
    </div>

    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="simpan" class="space-y-6">
        <!-- Baris 1: NIK & KK -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">NIK (16 Digit) <span class="text-red-500">*</span></label>
                <input type="text" wire:model="nik" required maxlength="16" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                @error('nik') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Kartu Keluarga (16 Digit) <span class="text-red-500">*</span></label>
                <input type="text" wire:model="no_kk" required maxlength="16" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                @error('no_kk') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Baris 2: Nama Lengkap -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap (Sesuai KTP) <span class="text-red-500">*</span></label>
            <input type="text" wire:model="nama_lengkap" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
            @error('nama_lengkap') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <!-- Baris 3: Tempat & Tanggal Lahir -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir <span class="text-red-500">*</span></label>
                <input type="text" wire:model="tempat_lahir" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                @error('tempat_lahir') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir <span class="text-red-500">*</span></label>
                <input type="date" wire:model="tanggal_lahir" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                @error('tanggal_lahir') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Baris 4: JK, Status, Pekerjaan -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                <select wire:model="jenis_kelamin" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    <option value="">-- Pilih --</option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
                @error('jenis_kelamin') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status Perkawinan <span class="text-red-500">*</span></label>
                <select wire:model="status_perkawinan" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    <option value="">-- Pilih --</option>
                    <option value="Belum Kawin">Belum Kawin</option>
                    <option value="Kawin">Kawin</option>
                    <option value="Cerai Hidup">Cerai Hidup</option>
                    <option value="Cerai Mati">Cerai Mati</option>
                </select>
                @error('status_perkawinan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan <span class="text-red-500">*</span></label>
                <input type="text" wire:model="pekerjaan" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                @error('pekerjaan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Baris 5: Alamat -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap Rumah <span class="text-red-500">*</span></label>
            <textarea wire:model="alamat" required rows="3" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="Nama jalan, nomor rumah, RT/RW, Banjar/Dusun..."></textarea>
            @error('alamat') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <!-- Baris 6: Upload Berkas Digital -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Upload Foto KTP (Max 2MB) <span class="text-red-500">*</span></label>
                <input type="file" wire:model="foto_ktp" required class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                @error('foto_ktp') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Upload Foto Kartu Keluarga (Max 2MB) <span class="text-red-500">*</span></label>
                <input type="file" wire:model="foto_kk" required class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                @error('foto_kk') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Tombol Kirim -->
        <div class="flex justify-end">
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg text-sm shadow-sm transition duration-150 cursor-pointer">
                Kirim Data Registrasi
            </button>
        </div>
    </form>
</div>