<div class="max-w-6xl mx-auto my-6 p-4 md:p-6 bg-gray-50/50 rounded-2xl border border-gray-100 shadow-sm">
    
    <div class="flex justify-between items-center bg-white p-6 rounded-xl border border-gray-100 shadow-sm mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-800">Selamat Datang, {{ Auth::user()->name }}!</h1>
            <p class="text-xs text-gray-500">Panel Mandiri Layanan Kependudukan Digital SI-MADE</p>
        </div>
        <button wire:click="logout" class="px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg text-xs font-semibold transition cursor-pointer">
            Keluar (Logout)
        </button>
    </div>

    @if($penduduk)
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-start">
            
            <div class="md:col-span-1 bg-white p-4 rounded-xl border border-gray-100 shadow-sm space-y-1">
                <p class="text-[10px] font-bold text-gray-400 uppercase px-3 mb-2 tracking-wider">Navigasi Layanan</p>
                
                <button wire:click="$set('activeTab', 'profil')" 
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-xs font-bold transition text-left cursor-pointer {{ $activeTab === 'profil' ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                    Profil Kependudukan
                </button>

                <button wire:click="$set('activeTab', 'surat')" 
                    {{ !$penduduk->is_aktif ? 'disabled' : '' }}
                    class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-xs font-bold transition text-left cursor-pointer {{ !$penduduk->is_aktif ? 'opacity-40 cursor-not-allowed text-gray-400' : ($activeTab === 'surat' ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50') }}">
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                        Layanan Surat
                    </div>
                    @if($penduduk->is_aktif && $riwayatSurat->count() > 0)
                        <span class="bg-indigo-600 text-white text-[10px] px-1.5 py-0.5 rounded-full font-mono">{{ $riwayatSurat->count() }}</span>
                    @endif
                </button>

                <button wire:click="$set('activeTab', 'pengaduan')" 
                    class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-xs font-bold transition text-left cursor-pointer {{ $activeTab === 'pengaduan' ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50' }}">
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                        </svg>
                        Pengaduan Warga
                    </div>
                </button>
            </div>

            <div class="md:col-span-3 space-y-6">
                
                <div class="p-4 rounded-xl flex items-center justify-between {{ $penduduk->is_aktif ? 'bg-green-50 border border-green-200 text-green-800' : 'bg-yellow-50 border border-yellow-200 text-yellow-800' }} shadow-sm bg-white">
                    <div>
                        <span class="font-bold text-xs block">Status Validasi Domisili:</span>
                        <span class="text-[11px]">{{ $penduduk->is_aktif ? 'Berkas Anda dinyatakan sah dan aktif oleh Desa.' : 'Berkas pendaftaran Anda sedang di-review oleh Perangkat Desa.' }}</span>
                    </div>
                    <div class="text-[10px] px-3 py-1 rounded-full uppercase font-bold {{ $penduduk->is_aktif ? 'bg-green-200 text-green-900' : 'bg-yellow-200 text-yellow-900' }}">
                        {{ $penduduk->is_aktif ? 'Terverifikasi' : 'Pending' }}
                    </div>
                </div>

                @if($activeTab === 'profil')
                    <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm space-y-4">
                        <h3 class="text-base font-bold text-gray-700 border-b pb-2">Informasi Data Penduduk</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                            <div>
                                <p class="text-gray-400">Nama Lengkap</p>
                                <p class="font-semibold text-gray-800 text-sm">{{ $penduduk->nama_lengkap }}</p>
                            </div>
                            <div>
                                <p class="text-gray-400">Nomor Induk Kependudukan (NIK)</p>
                                <p class="font-mono font-semibold text-gray-800 text-sm">{{ $penduduk->nik }}</p>
                            </div>
                            <div>
                                <p class="text-gray-400">Nomor Kartu Keluarga (KK)</p>
                                <p class="font-mono font-semibold text-gray-800 text-sm">{{ $penduduk->no_kk }}</p>
                            </div>
                            <div>
                                <p class="text-gray-400">Tempat, Tanggal Lahir</p>
                                <p class="font-semibold text-gray-800">{{ $penduduk->tempat_lahir }}, {{ $penduduk->tanggal_lahir }}</p>
                            </div>
                            <div>
                                <p class="text-gray-400">Pekerjaan</p>
                                <p class="font-semibold text-gray-800">{{ $penduduk->pekerjaan }}</p>
                            </div>
                            <div class="sm:col-span-2">
                                <p class="text-gray-400">Alamat Rumah Bersangkutan</p>
                                <p class="font-semibold text-gray-800 bg-gray-50 p-2.5 rounded-lg border border-gray-100 mt-1">{{ $penduduk->alamat }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if($activeTab === 'surat' && $penduduk->is_aktif)
                    <div class="bg-white p-6 rounded-xl border border-indigo-50 shadow-sm space-y-4">
                        <h3 class="text-base font-bold text-indigo-900 border-b pb-2">Formulir Permohonan Surat</h3>

                        @if (session()->has('message'))
                            <div class="p-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-xs font-medium">
                                {{ session('message') }}
                            </div>
                        @endif

                        <form wire:submit.prevent="ajukanSurat" class="space-y-4" enctype="multipart/form-data">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="md:col-span-1">
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Pilih Jenis Surat <span class="text-red-500">*</span></label>
                                    <select wire:model.live="jenis_surat" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-xs">
                                        <option value="">-- Pilih Surat --</option>
                                        <option value="Surat Keterangan Domisili">Surat Keterangan Domisili</option>
                                        <option value="Surat Keterangan Usaha (SKU)">Surat Keterangan Usaha (SKU)</option>
                                        <option value="Surat Keterangan Tidak Mampu (SKTM)">Surat Keterangan Tidak Mampu (SKTM)</option>
                                        <option value="Surat Keterangan Kelakuan Baik">Surat Keterangan Kelakuan Baik</option>
                                    </select>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Keperluan / Alasan Pengajuan <span class="text-red-500">*</span></label>
                                    <input type="text" wire:model="keperluan" required placeholder="Contoh: Syarat pengajuan beasiswa / Syarat membuat KUR" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-xs">
                                </div>
                            </div>

                            @if($jenis_surat)
                                <div class="bg-gray-50/70 p-4 rounded-xl border border-gray-100 space-y-4" wire:key="container-berkas-{{ $jenis_surat }}">
                                    <p class="text-xs font-bold text-gray-700 flex items-center gap-1">📎 Unggah Dokumen Persyaratan Wajib (Maks. 2MB per file)</p>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        @if($jenis_surat === 'Surat Keterangan Domisili')
                                            <div class="space-y-1" wire:key="wrap-domisili">
                                                <label class="block text-[11px] font-semibold text-gray-600">Scan Surat Pengantar RT/RW <span class="text-red-500">*</span></label>
                                                <input type="file" wire:model="bukti_pendukung.pengantar_rt" required class="block w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 border border-gray-200 rounded-lg p-1 bg-white shadow-sm">
                                                @error('bukti_pendukung.pengantar_rt') <span class="text-[10px] text-red-500 block font-medium">* {{ $message }}</span> @enderror
                                            </div>
                                        @elseif($jenis_surat === 'Surat Keterangan Usaha (SKU)')
                                            <div class="space-y-1" wire:key="wrap-sku-1">
                                                <label class="block text-[11px] font-semibold text-gray-600">Foto Fisik Tempat / Aktivitas Usaha <span class="text-red-500">*</span></label>
                                                <input type="file" wire:model="bukti_pendukung.foto_usaha" required class="block w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 border border-gray-200 rounded-lg p-1 bg-white shadow-sm">
                                                @error('bukti_pendukung.foto_usaha') <span class="text-[10px] text-red-500 block font-medium">* {{ $message }}</span> @enderror
                                            </div>
                                            <div class="space-y-1" wire:key="wrap-sku-2">
                                                <label class="block text-[11px] font-semibold text-gray-600">Nota Pembelian Bahan / Inventaris Usaha <span class="text-red-500">*</span></label>
                                                <input type="file" wire:model="bukti_pendukung.nota_insidentil" required class="block w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 border border-gray-200 rounded-lg p-1 bg-white shadow-sm">
                                                @error('bukti_pendukung.nota_insidentil') <span class="text-[10px] text-red-500 block font-medium">* {{ $message }}</span> @enderror
                                            </div>
                                        @elseif($jenis_surat === 'Surat Keterangan Tidak Mampu (SKTM)')
                                            <div class="space-y-1" wire:key="wrap-sktm-1">
                                                <label class="block text-[11px] font-semibold text-gray-600">Scan Surat Pengantar RT/RW <span class="text-red-500">*</span></label>
                                                <input type="file" wire:model="bukti_pendukung.pengantar_rt" required class="block w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 border border-gray-200 rounded-lg p-1 bg-white shadow-sm">
                                                @error('bukti_pendukung.pengantar_rt') <span class="text-[10px] text-red-500 block font-medium">* {{ $message }}</span> @enderror
                                            </div>
                                            <div class="space-y-1" wire:key="wrap-sktm-2">
                                                <label class="block text-[11px] font-semibold text-gray-600">Foto Rumah Tinggal Pemohon (Tampak Depan) <span class="text-red-500">*</span></label>
                                                <input type="file" wire:model="bukti_pendukung.foto_rumah" required class="block w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 border border-gray-200 rounded-lg p-1 bg-white shadow-sm">
                                                @error('bukti_pendukung.foto_rumah') <span class="text-[10px] text-red-500 block font-medium">* {{ $message }}</span> @enderror
                                            </div>
                                        @elseif($jenis_surat === 'Surat Keterangan Kelakuan Baik')
                                            <div class="space-y-1" wire:key="wrap-kelakuanbaik">
                                                <label class="block text-[11px] font-semibold text-gray-600">Surat Pengantar / Rekomendasi Kelian Banjar Dinas <span class="text-red-500">*</span></label>
                                                <input type="file" wire:model="bukti_pendukung.rekomendasi_banjar" required class="block w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 border border-gray-200 rounded-lg p-1 bg-white shadow-sm">
                                                @error('bukti_pendukung.rekomendasi_banjar') <span class="text-[10px] text-red-500 block font-medium">* {{ $message }}</span> @enderror
                                            </div>
                                        @endif
                                    </div>
                                    <div wire:loading wire:target="bukti_pendukung" class="text-[10px] text-indigo-600 font-semibold animate-pulse mt-2 block">
                                        ⏳ Sedang memproses dokumen ke server... mohon tunggu.
                                    </div>
                                </div>
                            @endif

                            <div class="flex justify-end border-t pt-3">
                                <button type="submit" wire:loading.attr="disabled" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-bold shadow transition cursor-pointer disabled:opacity-50">
                                    Kirim Pengajuan Surat
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                            <div>
                                <h3 class="text-sm font-bold text-gray-900">Status Pengajuan Surat</h3>
                                <p class="text-[11px] text-gray-400 mt-0.5">Pantau pengajuan surat Anda disini</p>
                            </div>
                            <span class="text-[10px] font-bold bg-indigo-50 text-indigo-600 px-2.5 py-1 rounded-full">{{ $riwayatSurat->count() }} Permohonan</span>
                        </div>

                        @forelse($riwayatSurat as $surat)
                            @php
                                $isDitolak = $surat->status === 'ditolak';
                                $activeStep = match(true) {
                                    $surat->status === 'pending' => 0,
                                    $surat->status === 'diproses' => 1, 
                                    ($surat->status === 'disetujui' || $surat->status === 'selesai') => 3,
                                    default => -1,
                                };
                                $steps = [
                                    ['label' => 'Permohonan Diterima', 'desc' => 'Berkas masuk ke sistem SI-MADE', 'step' => 0],
                                    ['label' => 'Verifikasi Perangkat Desa', 'desc' => 'Berkas diperiksa admin desa', 'step' => 1],
                                    ['label' => 'Menunggu TTD Kepala Desa', 'desc' => 'Surat diteruskan ke Kepala Desa', 'step' => 2],
                                    ['label' => 'Surat Selesai', 'desc' => 'Surat resmi siap diunduh warga', 'step' => 3],
                                ];
                            @endphp

                            <div class="px-6 py-5 {{ !$loop->last ? 'border-b border-gray-100' : '' }}" wire:key="riwayat-card-{{ $surat->id }}">
                                <div class="flex flex-wrap items-start justify-between gap-2 mb-5">
                                    <div>
                                        <p class="text-xs font-bold text-gray-800">{{ $surat->jenis_surat }}</p>
                                        <p class="text-[11px] text-gray-400 mt-0.5">Keperluan: {{ $surat->keperluan }}</p>
                                        <p class="text-[10px] text-gray-300 mt-0.5 font-mono">No. Ref: #{{ str_pad($surat->id, 6, '0', STR_PAD_LEFT) }} · Diajukan {{ $surat->created_at->format('d M Y - H:i') }} WITA</p>
                                    </div>
                                    @if($isDitolak)
                                        <span class="text-[10px] font-bold px-2.5 py-1 rounded-full bg-red-100 text-red-700 uppercase tracking-wide">Ditolak</span>
                                    @elseif($surat->status === 'disetujui' || $surat->status === 'selesai')
                                        <span class="text-[10px] font-bold px-2.5 py-1 rounded-full bg-green-100 text-green-700 uppercase tracking-wide">Selesai</span>
                                    @else
                                        <span class="text-[10px] font-bold px-2.5 py-1 rounded-full bg-indigo-100 text-indigo-700 uppercase tracking-wide animate-pulse">Diproses</span>
                                    @endif
                                </div>

                                @if($isDitolak)
                                    <div class="flex items-start gap-3 bg-red-50 border border-red-200 rounded-xl p-4">
                                        <div class="text-sm">❌</div>
                                        <div>
                                            <p class="text-xs font-bold text-red-800">Permohonan Ditolak</p>
                                            <p class="text-[11px] text-red-600 mt-1">{{ $surat->catatan_admin ?? 'Tidak ada keterangan tambahan dari admin.' }}</p>
                                        </div>
                                    </div>
                                @else
                                    <div class="relative">
                                        <div class="absolute left-[17px] top-5 bottom-5 w-0.5 bg-gray-100 z-0"></div>
                                        <div class="space-y-0">
                                            @foreach($steps as $index => $step)
                                                @php
                                                    $isDone = $activeStep >= $step['step'];
                                                    $isActive = $activeStep === $step['step'];
                                                    $isPending = $activeStep < $step['step'];
                                                @endphp
                                                <div class="relative flex items-start gap-4 z-10 pb-5 last:pb-0" wire:key="step-{{ $surat->id }}-{{ $index }}">
                                                    <div @class([
                                                        'w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold border-2 relative z-10',
                                                        'bg-indigo-600 border-indigo-600 text-white shadow-md' => $isActive,
                                                        'bg-green-500 border-green-500 text-white' => $isDone && !$isActive,
                                                        'bg-white border-gray-200 text-gray-300' => $isPending,
                                                    ])>
                                                        @if($isDone && !$isActive) ✓ @else {{ $index + 1 }} @endif
                                                    </div>
                                                    <div class="pt-1.5 flex-1 min-w-0">
                                                        <p @class(['text-xs font-bold', 'text-indigo-700' => $isActive, 'text-green-700' => $isDone && !$isActive, 'text-gray-300' => $isPending])>{{ $step['label'] }}</p>
                                                        <p @class(['text-[11px] mt-0.5', 'text-indigo-400' => $isActive, 'text-green-500' => $isDone && !$isActive, 'text-gray-300' => $isPending])>{{ $step['desc'] }}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                @if(($surat->status === 'disetujui' || $surat->status === 'selesai') && $surat->jalur_pdf)
                                    <div class="mt-5 pt-4 border-t border-gray-100 flex justify-end">
                                        <a href="{{ asset('storage/' . $surat->jalur_pdf) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold shadow-sm transition">
                                            Unduh Surat (PDF)
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="px-6 py-12 text-center">
                                <p class="text-sm font-semibold text-gray-500">Belum ada permohonan surat</p>
                            </div>
                        @endforelse
                    </div>
                @endif

                @if($activeTab === 'pengaduan')
                    <div class="space-y-6">
                        <livewire:pengaduan.riwayat-pengaduan-singkat />
                    </div>
                @endif

            </div>
        </div>
    @else
        <div class="p-4 bg-yellow-50 text-yellow-700 border border-yellow-200 rounded-lg">
            Akun user Anda terdeteksi, namun detail profil kependudukan fisik belum terhubung sempurna. Silakan hubungi perangkat desa.
        </div>
    @endif
</div>