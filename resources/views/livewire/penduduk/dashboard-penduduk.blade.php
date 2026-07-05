<div class="max-w-6xl mx-auto my-6 p-4 md:p-6 bg-slate-50/50 rounded-2xl border border-gray-200/80 shadow-sm animate-fade-in">
    
    <!-- 📄 🟠 HEADER DASHBOARD (GRADASI MEWAH FILAMENT + SHADOW LEBIH NYATA) -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-gradient-to-b from-amber-400 via-amber-500 to-orange-500 p-6 rounded-2xl border border-orange-600/20 shadow-md mb-6 gap-4 text-white">
        <div>
            <h1 class="text-lg font-black tracking-tight text-white">Selamat Datang, {{ Auth::user()->name }}!</h1>
            <p class="text-xs text-amber-50/90 mt-0.5 font-medium">Panel Mandiri Layanan Kependudukan Digital SI-MADE</p>
        </div>
        <button wire:click="logout" wire:confirm="Apakah Anda yakin ingin keluar?" class="px-4 py-2 bg-amber-950/20 hover:bg-amber-950/30 text-white border border-white/20 hover:border-white/40 rounded-xl text-xs font-bold transition duration-150 cursor-pointer shadow-sm backdrop-blur-sm">
            Keluar Sistem
        </button>
    </div>

    @if($penduduk)
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start">
            
            <!-- 🧭 SIDEBAR NAVIGASI -->
            <div class="md:col-span-3 bg-white p-4 rounded-2xl border-2 border-gray-200/80 shadow-md space-y-1">
                <p class="text-[10px] font-bold text-slate-400 uppercase px-3 mb-2 tracking-wider">Navigasi Layanan</p>
                
                @foreach([
                    'profil' => ['label' => 'Profil Kependudukan', 'icon' => 'user'], 
                    'surat' => ['label' => 'Layanan Surat', 'icon' => 'document-text'], 
                    'pengaduan' => ['label' => 'Pengaduan Warga', 'icon' => 'chat-bubble-left-right'],  
                    'lumbung' => ['label' => 'Lumbung Desa', 'icon' => 'building-storefront']
                ] as $tab => $data)
                    <button wire:click="$set('activeTab', '{{ $tab }}')" 
                        @if($tab === 'surat' && !$penduduk->is_aktif) disabled @endif
                        @class([
                            'w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-bold transition text-left cursor-pointer',
                            'bg-amber-50 text-amber-800 border-l-4 border-amber-500 pl-2' => $activeTab === $tab,
                            'text-slate-600 hover:bg-slate-50/80' => $activeTab !== $tab,
                            'opacity-40 cursor-not-allowed text-slate-400 hover:bg-transparent' => $tab === 'surat' && !$penduduk->is_aktif
                        ]) Granger>
                        <div class="flex items-center gap-3">
                            <x-dynamic-component :component="'heroicon-o-' . $data['icon']" class="w-4 h-4 text-slate-400" />
                            {{ $data['label'] }}
                        </div>
                        @if($tab === 'surat' && $penduduk->is_aktif && $riwayatSurat->count() > 0)
                            <span class="bg-amber-600 text-white text-[9px] px-1.5 py-0.5 rounded-full font-bold font-mono">{{ $riwayatSurat->count() }}</span>
                        @endif
                    </button>
                @endforeach
            </div>

            <!-- 💻 Area Konten Utama Kanan -->
            <div class="md:col-span-9 space-y-6">

                <!-- KONTEN TAB PROFIL WARGA -->
                @if($activeTab === 'profil')
                    <div @class([
                        'p-4 rounded-2xl flex items-center justify-between shadow-md bg-white border-2 mb-6',
                        'bg-emerald-50/60 border-emerald-200 text-emerald-900' => $penduduk->is_aktif,
                        'bg-amber-50/60 border-amber-200 text-amber-900' => !$penduduk->is_aktif
                    ])>
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-2 rounded-full {{ $penduduk->is_aktif ? 'bg-emerald-500' : 'bg-amber-500' }} animate-pulse"></div>
                            <div>
                                <span class="font-bold text-xs block">Status Validasi Domisili:</span>
                                <span class="text-[11px] text-slate-500 font-medium">{{ $penduduk->is_aktif ? 'Berkas Anda dinyatakan sah dan aktif oleh Desa.' : 'Berkas pendaftaran Anda sedang dalam proses verifikasi oleh Perangkat Desa.' }}</span>
                            </div>
                        </div>
                        <span @class([
                            'text-[10px] px-2.5 py-1 rounded-xl uppercase font-extrabold tracking-wider',
                            'bg-emerald-100 text-emerald-800' => $penduduk->is_aktif,
                            'bg-amber-100 text-amber-800' => !$penduduk->is_aktif
                        ])>
                            {{ $penduduk->is_aktif ? 'Terverifikasi' : 'Pending' }}
                        </span>
                    </div>

                    <div class="bg-white p-6 rounded-2xl border-2 border-gray-200/80 shadow-md space-y-5">
                        <div class="flex items-center justify-between border-b-2 border-slate-100 pb-3">
                            <h3 class="text-sm font-black text-slate-800 uppercase tracking-tight flex items-center gap-2">
                                <span class="w-1.5 h-3 bg-amber-500 rounded-sm"></span> Informasi Data Penduduk
                            </h3>
                            <span class="text-[10px] bg-slate-100 text-slate-500 font-bold px-2 py-0.5 rounded-md">Warga Asli</span>
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-xs">
                            @foreach(['Nama Lengkap' => $penduduk->nama_lengkap, 'NIK' => $penduduk->nik, 'No. KK' => $penduduk->no_kk, 'Tempat, Tanggal Lahir' => $penduduk->tempat_lahir . ', ' . $penduduk->tanggal_lahir, 'Pekerjaan' => $penduduk->pekerjaan] as $label => $value)
                                <div class="space-y-0.5 bg-slate-50/50 p-3 rounded-xl border border-slate-200/60">
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wide">{{ $label }}</p>
                                    <p class="font-bold text-slate-800 text-sm {{ str_contains($label, 'NIK') || str_contains($label, 'KK') ? 'font-mono tracking-wider text-slate-700' : '' }}">{{ $value }}</p>
                                </div>
                            @endforeach
                            <div class="sm:col-span-2 space-y-1">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wide">Alamat Rumah Bersangkutan</p>
                                <p class="font-semibold text-slate-700 bg-slate-50 p-3 rounded-xl border border-slate-200/60 leading-relaxed">{{ $penduduk->alamat }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- KONTEN TAB LAYANAN SURAT -->
                @if($activeTab === 'surat' && $penduduk->is_aktif)
                    <div class="bg-white p-6 rounded-2xl border-2 border-gray-200/80 shadow-md space-y-4">
                        <h3 class="text-sm font-black text-slate-800 border-b-2 border-slate-100 pb-3 uppercase tracking-tight flex items-center gap-2">
                            <span class="w-1.5 h-3 bg-amber-500 rounded-sm"></span> Formulir Permohonan Surat
                        </h3>
                        
                        @if (session()->has('message'))
                            <div class="p-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-xs font-medium flex items-center gap-2">
                                <x-heroicon-o-check-circle class="w-4 h-4" /> {{ session('message') }}
                            </div>
                        @endif

                        <form wire:submit.prevent="ajukanSurat" class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="md:col-span-1">
                                    <label class="block text-xs font-semibold text-slate-600 mb-1">Pilih Jenis Surat <span class="text-red-500">*</span></label>
                                    <select wire:model.live="jenis_surat" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 text-xs">
                                        <option value="">-- Pilih Jenis Surat --</option>
                                        <option value="Surat Keterangan Domisili">Surat Keterangan Domisili</option>
                                        <option value="Surat Keterangan Usaha (SKU)">Surat Keterangan Usaha (SKU)</option>
                                        <option value="Surat Keterangan Tidak Mampu (SKTM)">Surat Keterangan Tidak Mampu (SKTM)</option>
                                        <option value="Surat Pengantar SKCK">Surat Pengantar SKCK</option>
                                        <option value="Surat Pindah">Surat Pindah</option>
                                        <option value="Surat Keterangan Kematian">Surat Keterangan Kematian</option>
                                        <option value="Surat Keterangan Ahli Waris">Surat Keterangan Ahli Waris</option>
                                        <option value="Surat Keterangan Kelahiran">Surat Keterangan Kelahiran</option>
                                    </select>
                                    @error('jenis_surat') <span class="text-[10px] text-red-500 block font-medium mt-1">* {{ $message }}</span> @enderror
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-semibold text-slate-600 mb-1">Keperluan / Alasan Pengajuan <span class="text-red-500">*</span></label>
                                    <input type="text" wire:model="keperluan" required placeholder="Contoh: Syarat pengajuan beasiswa / Syarat membuat KUR" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 text-xs">
                                    @error('keperluan') <span class="text-[10px] text-red-500 block font-medium mt-1">* {{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- ================================================================= -->
                            <!-- 🌟 CARD INTERAKTIF: INPUT FORM DINAMIS (DI-RENDER OTOMATIS) 🌟     -->
                            <!-- ================================================================= -->
                            @if(!empty($dynamicFormFields))
                                <div class="bg-slate-50/80 p-5 rounded-2xl border border-slate-200 space-y-4 animate-in fade-in duration-300">
                                    <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wide flex items-center gap-1.5">
                                        <span class="w-1 h-2.5 bg-orange-500 rounded-sm"></span> Informasi Detail Pengisian Formulir
                                    </h4>
                                    
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        @foreach($dynamicFormFields as $field)
                                            <div class="{{ $field['type'] === 'textarea' ? 'sm:col-span-2' : '' }} space-y-1">
                                                <label class="block text-[11px] font-semibold text-slate-600">
                                                    {{ $field['label'] }} @if($field['required']) <span class="text-red-500">*</span> @endif
                                                </label>
                                                
                                                @if($field['type'] === 'text' || $field['type'] === 'date')
                                                    <input type="{{ $field['type'] }}" wire:model="data_kustom.{{ $field['name'] }}" {{ $field['required'] ? 'required' : '' }} placeholder="{{ $field['placeholder'] ?? '' }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 text-xs bg-white">
                                                @elseif($field['type'] === 'select')
                                                    <select wire:model="data_kustom.{{ $field['name'] }}" {{ $field['required'] ? 'required' : '' }} class="w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 text-xs bg-white">
                                                        <option value="">-- Pilih {{ $field['label'] }} --</option>
                                                        @foreach($field['options'] as $opt)
                                                            <option value="{{ $opt }}">{{ $opt }}</option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                                @error('data_kustom.' . $field['name']) <span class="text-[10px] text-red-500 block font-medium">* {{ $message }}</span> @enderror
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- ================================================================= -->
                            <!-- 🌟 CARD INTERAKTIF: AREA UPLOAD DINAMIS DENGAN CHECKLIST 🌟        -->
                            <!-- ================================================================= -->
                            @if(!empty($dynamicUploadFields))
                                <div class="bg-slate-50/70 p-4 rounded-xl border border-gray-200 space-y-4 animate-in fade-in duration-300">
                                    <p class="text-xs font-bold text-slate-700 flex items-center gap-1">
                                        <span>📎 Dokumen Berkas Persyaratan Wajib</span>
                                        <span class="text-[10px] text-slate-400 font-normal">(Maks. 2MB per file)</span>
                                    </p>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        @foreach($dynamicUploadFields as $upload)
                                            <div class="space-y-1 bg-white p-3 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between">
                                                <div>
                                                    <label class="block text-[11px] font-bold text-slate-700 flex items-center gap-1.5">
                                                        <span class="{{ isset($bukti_pendukung[$upload['name']]) ? 'text-emerald-500' : 'text-slate-300' }} font-bold text-xs">
                                                            {{ isset($bukti_pendukung[$upload['name']]) ? '☑' : '☐' }}
                                                        </span>
                                                        {{ $upload['label'] }} 
                                                        @if($upload['required']) <span class="text-red-500">*</span> @else <span class="text-slate-400 font-normal text-[9px]">(Opsional)</span> @endif
                                                    </label>
                                                    <span class="text-[9px] text-slate-400 block mt-0.5">Format: {{ str_replace('.', '', $upload['accept']) }} (Max {{ $upload['max'] }})</span>
                                                </div>
                                                
                                                <input type="file" wire:model="bukti_pendukung.{{ $upload['name'] }}" {{ $upload['required'] ? 'required' : '' }} accept="{{ $upload['accept'] }}" class="block w-full text-xs text-gray-500 file:mr-2 file:py-1 file:px-2 file:rounded-md file:border-0 file:text-[10px] file:font-bold file:bg-amber-50 file:text-amber-800 hover:file:bg-amber-100 border border-gray-100 rounded-lg p-1 bg-slate-50/50 mt-2">
                                                @error('bukti_pendukung.' . $upload['name']) <span class="text-[10px] text-red-500 block font-medium mt-1">* {{ $message }}</span> @enderror
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="flex justify-end border-t border-slate-100 pt-3">
                                <button type="submit" wire:loading.attr="disabled" class="px-5 py-2 bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white rounded-xl text-xs font-bold shadow-sm transition cursor-pointer disabled:opacity-50">
                                    Kirim Pengajuan Surat
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- TABEL STATUS SURAT -->
                    <div class="bg-white rounded-2xl border-2 border-gray-200/80 shadow-md overflow-hidden">
                        <div class="bg-amber-500 px-6 py-4 flex items-center justify-between text-white">
                            <div>
                                <h3 class="text-sm font-extrabold flex items-center gap-2"> Status Pengajuan Surat</h3>
                                <p class="text-[11px] text-amber-50/90 mt-0.5 font-medium">Pantau berkas permohonan surat administrasi Anda di sini</p>
                            </div>
                            <span class="text-[10px] font-bold bg-amber-950/20 text-white px-2.5 py-1 rounded-xl border border-white/10">{{ $riwayatSurat->count() }} Permohonan</span>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs">
                                <thead class="bg-amber-50/50 text-amber-950 uppercase font-bold text-[10px] tracking-wider border-b-2 border-amber-200/60">
                                    <tr>
                                        <th class="p-4">Tanggal Pengajuan</th>
                                        <th class="p-4">Jenis Surat Keluar</th>
                                        <th class="p-4">Keperluan / Keterangan</th>
                                        <th class="p-4 text-center">Status Berkas</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y-2 divide-gray-100 text-slate-600">
                                    @forelse($riwayatSurat as $surat)
                                        <tr class="hover:bg-amber-50/20 transition">
                                            <td class="p-4 font-medium">{{ $surat->created_at->format('d M Y') }}</td>
                                            <td class="p-4 text-slate-900 font-bold flex items-center gap-2">
                                                <span class="w-2 h-2 rounded-full bg-amber-400 shadow-sm"></span>
                                                {{ $surat->jenis_surat }}
                                            </td>
                                            <td class="p-4 font-medium max-w-xs truncate text-slate-700">{{ $surat->keperluan }}</td>
                                            <td class="p-4 text-center">
                                                <span @class([
                                                    'px-2.5 py-1 rounded-xl text-[9px] font-extrabold uppercase tracking-wide border',
                                                    'bg-red-50 text-red-700 border-red-100' => $surat->status === 'ditolak',
                                                    'bg-emerald-50 text-emerald-700 border-emerald-100' => in_array($surat->status, ['disetujui', 'selesai']),
                                                    'bg-amber-50 text-amber-800 border-amber-100 animate-pulse' => !in_array($surat->status, ['ditolak', 'disetujui', 'selesai'])
                                                ])>
                                                    {{ $surat->status === 'disetujui' || $surat->status === 'selesai' ? 'Selesai' : ($surat->status === 'ditolak' ? 'Ditolak' : 'Diproses') }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="p-8 text-center text-slate-400 italic font-medium bg-gray-50/30">
                                                Belum ada permohonan surat yang diajukan.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

                <!-- Konten Tab Pengaduan -->
                @if($activeTab === 'pengaduan')
                    <div class="space-y-6">
                        <livewire:pengaduan.riwayat-pengaduan-singkat />
                    </div>
                @endif

                <!-- KONTEN TAB LUMBUNG DESA -->
                @if($activeTab === 'lumbung' && $penduduk->is_aktif)
                    <div class="space-y-6">
                        <div class="bg-white rounded-2xl border-2 border-gray-200/80 shadow-md overflow-hidden">
                            <div class="bg-amber-500 px-6 py-4 flex items-center justify-between text-white">
                                <div>
                                    <h3 class="text-sm font-extrabold flex items-center gap-2">Riwayat Manfaat & Bantuan Diterima</h3>
                                    <p class="text-[11px] text-amber-50/95 mt-0.5 font-medium">Daftar bantuan resmi lumbung desa yang telah disalurkan kepada Anda</p>
                                </div>
                                <span class="text-[10px] font-bold bg-amber-950/20 text-white px-2.5 py-1 rounded-xl border border-white/10">{{ $riwayatPenerimaan->count() }} Paket</span>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-xs">
                                    <thead class="bg-amber-50/50 text-amber-950 uppercase font-bold text-[10px] tracking-wider border-b-2 border-amber-200/60">
                                        <tr>
                                            <th class="p-4">Tanggal Terima</th>
                                            <th class="p-4">Nama Bantuan / Barang</th>
                                            <th class="p-4">Jumlah Volume</th>
                                            <th class="p-4">Sumber Pendanaan</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y-2 divide-gray-100 text-slate-600">
                                        @forelse($riwayatPenerimaan as $terima)
                                            <tr class="hover:bg-amber-50/20 transition">
                                                <td class="p-4 font-medium text-slate-700">{{ $terima->created_at->format('d M Y') }}</td>
                                                <td class="p-4 text-slate-900 font-bold flex items-center gap-2">
                                                    <span class="w-2 h-2 rounded-full bg-amber-400 shadow-sm"></span>
                                                    {{ $terima->nama_barang }}
                                                </td>
                                                <td class="p-4 font-mono font-bold text-orange-600">+ {{ $terima->jumlah_bantuan }} Unit / Kg</td>
                                                <td class="p-4">
                                                    <span class="px-2 py-0.5 bg-amber-50/60 text-amber-800 rounded text-[10px] font-semibold border border-amber-100">
                                                        {{ $terima->sumber_bantuan }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="p-8 text-center text-slate-400 italic font-medium bg-gray-50/30">
                                                    Anda belum terdata sebagai penerima bantuan sosial lumbung desa periode ini.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="p-6 bg-white border-2 border-amber-200 rounded-2xl shadow-md text-center max-w-md mx-auto my-12">
            <x-heroicon-o-exclamation-triangle class="w-10 h-10 text-amber-500 mx-auto mb-2" />
            <p class="text-sm font-black text-slate-800">Profil Kependudukan Belum Lengkap</p>
            <p class="text-xs text-slate-400 mt-1 font-medium">Silakan hubungi administrator atau perangkat desa untuk melengkapi data profil fisik Anda.</p>
        </div>
    @endif
</div>