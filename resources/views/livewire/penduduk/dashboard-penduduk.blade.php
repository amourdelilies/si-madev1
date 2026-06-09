<div class="max-w-4xl mx-auto my-6 p-8 bg-white rounded-xl shadow-md border border-gray-100">
    <!-- Header Dashboard -->
    <div class="flex justify-between items-center border-b pb-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Selamat Datang, {{ Auth::user()->name }}!</h1>
            <p class="text-sm text-gray-500">Panel Mandiri Layanan Kependudukan Digital SI-MADE</p>
        </div>
        <button wire:click="logout" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm font-medium transition shadow-sm cursor-pointer">
            Keluar (Logout)
        </button>
    </div>

    @if($penduduk)
        <!-- Kotak Status Validasi -->
        <div class="mb-6 p-4 rounded-lg flex items-center justify-between {{ $penduduk->is_aktif ? 'bg-green-50 border border-green-200 text-green-800' : 'bg-yellow-50 border border-yellow-200 text-yellow-800' }}">
            <div>
                <span class="font-bold text-sm block">Status Akun Domisili:</span>
                <span class="text-xs">{{ $penduduk->is_aktif ? ' Aktif / Terverifikasi Perangkat Desa' : ' Menunggu Verifikasi Berkas oleh Perangkat Desa' }}</span>
            </div>
            <div class="text-xs px-3 py-1 rounded-full uppercase font-bold {{ $penduduk->is_aktif ? 'bg-green-200 text-green-900' : 'bg-yellow-200 text-yellow-900' }}">
                {{ $penduduk->is_aktif ? 'Terverifikasi' : 'Pending' }}
            </div>
        </div>

        <!-- Detail Data Ringkas Warga -->
        <div class="bg-gray-50 p-6 rounded-xl border border-gray-100 space-y-4 mb-6">
            <h3 class="text-lg font-semibold text-gray-700 border-b pb-2"> Profil Kependudukan Anda</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-400">Nama Lengkap</p>
                    <p class="font-medium text-gray-800">{{ $penduduk->nama_lengkap }}</p>
                </div>
                <div>
                    <p class="text-gray-400">Nomor Induk Kependudukan (NIK)</p>
                    <p class="font-medium text-gray-800">{{ $penduduk->nik }}</p>
                </div>
                <div>
                    <p class="text-gray-400">Nomor Kartu Keluarga (KK)</p>
                    <p class="font-medium text-gray-800">{{ $penduduk->no_kk }}</p>
                </div>
                <div>
                    <p class="text-gray-400">Tempat, Tanggal Lahir</p>
                    <p class="font-medium text-gray-800">{{ $penduduk->tempat_lahir }}, {{ $penduduk->tanggal_lahir }}</p>
                </div>
                <div>
                    <p class="text-gray-400">Pekerjaan</p>
                    <p class="font-medium text-gray-800">{{ $penduduk->pekerjaan }}</p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-gray-400">Alamat Rumah</p>
                    <p class="font-medium text-gray-800">{{ $penduduk->alamat }}</p>
                </div>
            </div>
        </div>

        <!-- 🌟 KONDISI OTOMATIS JIKA SUDAH AKTIF: MUNCULKAN FORM PENGAJUAN SURAT -->
        @if($penduduk->is_aktif)
            <div class="bg-white p-6 rounded-xl border border-indigo-100 shadow-sm space-y-4">
                <h3 class="text-lg font-semibold text-indigo-900 border-b pb-2 flex items-center gap-2">
                     Layanan Pengajuan Surat Pengantar Digital
                </h3>

                @if (session()->has('message'))
                    <div class="p-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-xs font-medium">
                        {{ session('message') }}
                    </div>
                @endif

                <form wire:submit.prevent="ajukanSurat" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="md:col-span-1">
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Pilih Jenis Surat <span class="text-red-500">*</span></label>
                            <select wire:model="jenis_surat" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                <option value="">-- Pilih Surat --</option>
                                <option value="Surat Keterangan Domisili">Surat Keterangan Domisili</option>
                                <option value="Surat Keterangan Usaha (SKU)">Surat Keterangan Usaha (SKU)</option>
                                <option value="Surat Keterangan Tidak Mampu (SKTM)">Surat Keterangan Tidak Mampu (SKTM)</option>
                                <option value="Surat Keterangan Kelakuan Baik">Surat Keterangan Kelakuan Baik</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Keperluan / Alasan Pengajuan <span class="text-red-500">*</span></label>
                            <input type="text" wire:model="keperluan" required placeholder="Contoh: Syarat mencari pekerjaan / Syarat pengajuan KUR Bank" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        </div>
                    </div>

                    <div class="flex justify-end border-t pt-3">
                        <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-bold shadow transition duration-150 cursor-pointer">
                            Kirim Pengajuan Surat
                        </button>
                    </div>
                </form>
            </div>
        @endif

    @else
        <div class="p-4 bg-yellow-50 text-yellow-700 border border-yellow-200 rounded-lg">
            Akun user Anda terdeteksi, namun detail profil kependudukan fisik belum terhubung sempurna. Silakan hubungi perangkat desa.
        </div>
    @endif
</div>