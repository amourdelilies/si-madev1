<div class="flex flex-col justify-center items-center px-4" style="min-height: calc(100vh - 80px);">
<div class="max-w-5xl mx-auto my-8 p-1 bg-gradient-to-tr from-amber-400 via-indigo-500 to-indigo-600 rounded-2xl shadow-xl">
    <div class="bg-white rounded-xl p-6 md:p-8 relative overflow-hidden">
        
        <div class="absolute -top-10 -right-10 w-40 h-40 bg-amber-200/30 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-indigo-200/20 rounded-full blur-2xl pointer-events-none"></div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 relative z-10">
        
            <div class="lg:col-span-4 flex flex-col justify-between bg-gray-50/80 p-6 rounded-xl border border-gray-100">
                <div class="space-y-4">
                    <div class="inline-flex p-3 bg-amber-500 text-white rounded-xl shadow-md shadow-amber-500/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Form Pengaduan Warga</h2>
                        <p class="text-xs text-gray-500 mt-1 leading-relaxed">Suara Anda adalah motor perubahan desa. Laporkan keluhan infrastruktur, pelayanan, atau gangguan keamanan secara langsung di sini.</p>
                    </div>

                    <div class="pt-4 space-y-3">
                        <div class="flex items-center gap-3 text-xs text-gray-600">
                            <span class="w-5 h-5 rounded-full bg-indigo-50 border border-indigo-200 flex items-center justify-center font-bold text-indigo-600">1</span>
                            <span>Isi laporan dengan data valid</span>
                        </div>
                        <div class="flex items-center gap-3 text-xs text-gray-600">
                            <span class="w-5 h-5 rounded-full bg-indigo-50 border border-indigo-200 flex items-center justify-center font-bold text-indigo-600">2</span>
                            <span>Verifikasi berkala oleh admin</span>
                        </div>
                        <div class="flex items-center gap-3 text-xs text-gray-600">
                            <span class="w-5 h-5 rounded-full bg-indigo-50 border border-indigo-200 flex items-center justify-center font-bold text-indigo-600">3</span>
                            <span>Pantau progres di dashboard utama</span>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-200/60 text-[10px] text-gray-400">
                    Sistem Pelaporan Digital Terintegrasi SI-MADE • 2026
                </div>
            </div>

            <form wire:submit.prevent="simpanPengaduan" class="lg:col-span-8 space-y-5">
                
                @if (session()->has('success'))
                    <div class="p-4 text-sm text-green-800 rounded-xl bg-green-50 border border-green-100 flex items-center gap-3 animate-fade-in" role="alert">
                        <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0x"/></svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                @endif

                <div class="space-y-1">
                    <label class="block text-xs font-semibold text-gray-600">Judul Laporan / Topik Aduan <span class="text-red-500">*</span></label>
                    <div class="relative rounded-lg shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </div>
                        <input type="text" wire:model="judul_pengaduan" placeholder="Tuliskan judul singkat, padat, dan jelas" class="block w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2.5">
                    </div>
                    @error('judul_pengaduan') <span class="text-xs font-medium text-red-500 block mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-semibold text-gray-600">Kategori Laporan <span class="text-red-500">*</span></label>
                    <div class="relative rounded-lg shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                        </div>
                        <select wire:model="kategori" class="block w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2.5 bg-white">
                            <option value="">-- Pilih Kategori Pengaduan --</option>
                            <option value="infrastruktur">Infrastruktur & Fasilitas Umum</option>
                            <option value="kebersihan">Kebersihan & Kesehatan Lingkungan</option>
                            <option value="pelayanan">Layanan Publik & Administrasi Desa</option>
                            <option value="keamanan">Keamanan, Ketertiban & Konflik Sosial</option>
                        </select>
                    </div>
                    @error('kategori') <span class="text-xs font-medium text-red-500 block mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-semibold text-gray-600">Isi Pengaduan / Kronologi Keluhan <span class="text-red-500">*</span></label>
                    <textarea wire:model="deskripsi_pengaduan" rows="5" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm p-3 border" placeholder="Jelaskan kronologi kejadian secara detail (hari, lokasi kejadian, dan dampak yang dirasakan warga)..."></textarea>
                    @error('deskripsi_pengaduan') <span class="text-xs font-medium text-red-500 block mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center justify-between border-t pt-4 mt-6">
                    <a href="{{ url('/warga/dashboard') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-gray-500 hover:text-gray-700 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Kembali ke Dashboard
                    </a>
                    
                    <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white text-xs font-bold rounded-lg shadow-md shadow-amber-500/10 transition duration-150 cursor-pointer">
                        Kirim Laporan Resmi
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
</div>
