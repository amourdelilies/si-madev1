<div>

    <div class="mt-8 mb-6 p-5 bg-amber-50/60 rounded-xl border border-amber-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="flex items-start gap-3">
            <div class="p-2.5 bg-amber-500 text-white rounded-lg shrink-0 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                </svg>
            </div>
            <div>
                <h3 class="text-sm font-bold text-amber-900">Memiliki keluhan terkait desa? Mari melapor!</h3>
                <p class="text-xs text-amber-700/90 mt-0.5">Sampaikan aspirasi, keluhan infrastruktur, hingga gangguan keamanan demi kenyamanan desa kita bersama.</p>
            </div>
        </div>
        <a href="{{ url('/pengaduan/create') }}" class="w-full sm:w-auto text-center px-4 py-2.5 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-lg transition duration-150 shadow-sm shrink-0">
            Kunjungi Halaman Pengaduan
        </a>
    </div>

    <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm space-y-4 mt-4">
        <div class="flex justify-between items-center border-b pb-2">
            <h3 class="text-sm font-bold text-gray-700 flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Status Pengaduan Terbaru Anda
            </h3>
            
            @if(!$semuaPengaduan->isEmpty())
                <a href="{{ url('/pengaduan/riwayat') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 transition flex items-center gap-1">
                    Lihat Semua
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            @endif
        </div>

        @if($semuaPengaduan->isEmpty())
            <div class="py-6 text-center bg-gray-50/50 rounded-lg border border-dashed border-gray-200">
                <p class="text-xs text-gray-400">Anda belum memiliki riwayat laporan pengaduan saat ini.</p>
            </div>
        @else
            <div class="overflow-x-auto rounded-lg border border-gray-100 bg-gray-50/50">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100/80 text-[11px] font-bold uppercase text-gray-600 tracking-wider border-b border-gray-200">
                            <th class="px-4 py-3">Judul Laporan</th>
                            <th class="px-4 py-3 text-center w-32">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs">
                        @foreach($semuaPengaduan as $aduan)
                            <tr class="hover:bg-white transition duration-100">
                                <td class="px-4 py-3.5 font-medium text-gray-800 truncate max-w-xs md:max-w-md">
                                    {{ $aduan->judul_pengaduan }}
                                </td>
                                <td class="px-4 py-3.5 text-center whitespace-nowrap">
                                    @if($aduan->status === 'dikirim')
                                        <span class="inline-flex items-center px-2.5 py-0.5 text-[10px] font-bold rounded-full bg-blue-50 text-blue-700 border border-blue-100">
                                            Dikirim
                                        </span>
                                    @elseif($aduan->status === 'diproses')
                                        <span class="inline-flex items-center px-2.5 py-0.5 text-[10px] font-bold rounded-full bg-amber-50 text-amber-700 border border-amber-100">
                                            Diproses
                                        </span>
                                    @elseif($aduan->status === 'selesai')
                                        <span class="inline-flex items-center px-2.5 py-0.5 text-[10px] font-bold rounded-full bg-green-50 text-green-700 border border-green-100">
                                            Selesai
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 text-[10px] font-bold rounded-full bg-gray-50 text-gray-600 border border-gray-200">
                                            {{ ucfirst($aduan->status) }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div> 