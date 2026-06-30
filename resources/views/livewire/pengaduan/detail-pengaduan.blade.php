<div class="w-full flex items-center justify-center p-4 md:p-8" style="min-height: calc(100vh - 40px);">
    
    <div class="w-full max-w-4xl bg-white rounded-2xl border border-gray-100 shadow-xl overflow-hidden">
        
        <div class="p-6 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ url('/pengaduan/riwayat') }}" class="p-2 bg-gray-100 text-gray-500 hover:text-gray-700 rounded-lg transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <div>
                    <h2 class="text-lg font-bold text-gray-800">Detail Laporan Resmi</h2>
                    <p class="text-xs text-gray-400 mt-0.5">ID Pengaduan: #{{ $pengaduan->id }}</p>
                </div>
            </div>

         
            <div>
                @if($pengaduan->status === 'dikirim')
                    <span class="inline-flex items-center px-3 py-1 text-xs font-bold rounded-full bg-blue-50 text-blue-700 border border-blue-100">● Dikirim</span>
                @elseif($pengaduan->status === 'diproses')
                    <span class="inline-flex items-center px-3 py-1 text-xs font-bold rounded-full bg-amber-50 text-amber-700 border border-amber-100">● Sedang Diproses</span>
                @elseif($pengaduan->status === 'selesai')
                    <span class="inline-flex items-center px-3 py-1 text-xs font-bold rounded-full bg-green-50 text-green-700 border border-green-100">● Selesai Ditangani</span>
                @else
                    <span class="inline-flex items-center px-3 py-1 text-xs font-bold rounded-full bg-gray-50 text-gray-600 border border-gray-200">● {{ ucfirst($pengaduan->status) }}</span>
                @endif
            </div>
        </div>

        <!-- Grid Informasi -->
        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
            
           
            <div class="md:col-span-2 space-y-5">
                <div>
                    <span class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Judul Laporan</span>
                    <h1 class="text-xl font-extrabold text-gray-900 mt-0.5">{{ $pengaduan->judul_pengaduan }}</h1>
                </div>

                <hr class="border-gray-100">

                <div>
                    <span class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Deskripsi Lengkap Kronologi</span>
                    <p class="text-sm text-gray-600 leading-relaxed mt-2 bg-gray-50/50 p-4 rounded-xl border border-gray-100 whitespace-pre-line">
                        {!! nl2br(e($pengaduan->deskripsi_pengaduan)) !!}
                    </p>
                </div>
            </div>

            <!-- Sisi Kanan: Meta-Data & Timeline Singkat (1 Kolom) -->
            <div class="bg-gray-50/80 p-5 rounded-2xl border border-gray-100 space-y-4 self-start">
                <h3 class="text-xs font-bold text-gray-700 uppercase tracking-wide border-b pb-2">Informasi Tiket</h3>
                
                <div>
                    <label class="text-[10px] font-bold text-gray-400 uppercase">Kategori Laporan</label>
                    <p class="text-xs font-semibold text-gray-700 mt-0.5 bg-white px-2.5 py-1.5 rounded-md border border-gray-100">{{ $pengaduan->kategori }}</p>
                </div>

                <div>
                    <label class="text-[10px] font-bold text-gray-400 uppercase">Tanggal Pengajuan</label>
                    <p class="text-xs font-semibold text-gray-700 mt-0.5 bg-white px-2.5 py-1.5 rounded-md border border-gray-100">
                        {{ $pengaduan->created_at->format('d F Y') }} <span class="text-gray-400 text-[10px] font-normal">({{ $pengaduan->created_at->format('H:i') }} WITA)</span>
                    </p>
                </div>

                <div>
                    <label class="text-[10px] font-bold text-gray-400 uppercase">Pembaruan Terakhir</label>
                    <p class="text-xs font-semibold text-gray-500 mt-0.5">
                        {{ $pengaduan->updated_at->diffForHumans() }}
                    </p>
                </div>
            </div>

        </div>

        <!-- Footer Aksi -->
        <div class="px-6 py-4 bg-gray-50/40 border-t border-gray-100 flex items-center justify-between text-xs">
            <a href="{{ url('/pengaduan/riwayat') }}" class="font-bold text-gray-500 hover:text-gray-700 transition flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali ke Daftar Riwayat
            </a>
            
            <!-- Tempat Masa Depan untuk tombol "Batalkan Pengaduan" jika status masih dikirim -->
            @if($pengaduan->status === 'dikirim')
                <span class="text-[11px] text-amber-600 font-medium bg-amber-50 px-2 py-0.5 rounded border border-amber-100">Menunggu Verifikasi Perangkat Desa</span>
            @endif
        </div>

    </div>
</div>