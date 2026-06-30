<div class="w-full flex items-center justify-center p-4 md:p-8" style="min-height: calc(100vh - 40px);">
    
    <div class="w-full max-w-5xl bg-white rounded-2xl border border-gray-100 shadow-xl overflow-hidden">
        
        <div class="p-6 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2.5 bg-amber-500 text-white rounded-xl shadow-md shadow-amber-600/10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Riwayat Pengaduan Anda</h2>
                    <p class="text-xs text-gray-500 mt-0.5">Daftar seluruh aspirasi dan laporan resmi yang telah Anda ajukan ke desa</p>
                </div>
            </div>

            <a href="{{ url('/pengaduan/create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-amber-500 hover:bg-amber-700 text-white text-xs font-bold rounded-lg shadow-sm transition duration-150">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Buat Laporan Baru
            </a>
        </div>

        <div class="p-6">
            
            @if($semuaPengaduan->isEmpty())
                <div class="py-16 text-center bg-gray-50/50 rounded-2xl border border-dashed border-gray-200 flex flex-col items-center justify-center">
                    <div class="p-4 bg-gray-100 text-gray-400 rounded-full mb-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                    </div>
                    <h3 class="text-sm font-bold text-gray-700">Belum Ada Riwayat Laporan</h3>
                    <p class="text-xs text-gray-400 mt-1 max-w-sm">Semua keluhan atau aspirasi yang Anda kirimkan nantinya akan terdata secara transparan di halaman ini.</p>
                </div>

            @else
                <div class="overflow-x-auto rounded-xl border border-gray-100 bg-gray-50/30">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100/70 text-[11px] font-bold uppercase text-gray-600 tracking-wider border-b border-gray-200">
                                <th class="px-6 py-4 w-28">Tanggal</th>
                                <th class="px-6 py-4">Judul Laporan / Keluhan</th>
                                <th class="px-6 py-4 text-center w-36">Status</th>
                                <th class="px-6 py-4 text-center w-28">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-xs">
                            @foreach($semuaPengaduan as $aduan)
                                <tr class="hover:bg-white transition duration-150">
                                    <td class="px-6 py-4 text-gray-500 font-medium whitespace-nowrap">
                                        {{ $aduan->created_at->format('d M Y') }}
                                    </td>
                                    
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-gray-800 text-sm truncate max-w-xs md:max-w-md">
                                            {{ $aduan->judul_pengaduan }}
                                        </div>
                                        <div class="text-[11px] text-gray-400 mt-0.5 uppercase tracking-wide">
                                            Kategori: {{ $aduan->kategori }}
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        @if($aduan->status === 'dikirim')
                                            <span class="inline-flex items-center px-2.5 py-1 text-[10px] font-bold rounded-full bg-blue-50 text-blue-700 border border-blue-100">
                                                Dikirim
                                            </span>
                                        @elseif($aduan->status === 'diproses')
                                            <span class="inline-flex items-center px-2.5 py-1 text-[10px] font-bold rounded-full bg-amber-50 text-amber-700 border border-amber-100">
                                                Diproses
                                            </span>
                                        @elseif($aduan->status === 'selesai')
                                            <span class="inline-flex items-center px-2.5 py-1 text-[10px] font-bold rounded-full bg-green-50 text-green-700 border border-green-100">
                                                Selesai
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 text-[10px] font-bold rounded-full bg-gray-50 text-gray-600 border border-gray-200">
                                                {{ ucfirst($aduan->status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        <a href="{{ url('/pengaduan/riwayat/' . $aduan->id) }}" class="inline-flex items-center gap-1 text-xs font-bold text-gray-400 hover:text-indigo-600 transition cursor-pointer">
                                            Detail
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-5">
                    {{ $semuaPengaduan->links() }}
                </div>
            @endif
        </div>

        <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100 flex items-center justify-between text-xs">
            <a href="{{ url('/warga/dashboard') }}" class="inline-flex items-center gap-1.5 font-bold text-gray-500 hover:text-gray-700 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Dashboard Utama
            </a>
            <span class="text-[11px] text-gray-400 font-medium">SI-MADE