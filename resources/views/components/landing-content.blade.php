<!-- resources/views/components/landing-content.blade.php -->
<div class="bg-white">
    <!-- page 1 -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-20 min-h-[85vh] flex items-center">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-8 items-center">
            
            <!-- Kiri: Gambar Estetis Bali (Tukaran dari About sebelumnya) -->
            <div class="order-2 lg:order-1 flex justify-center lg:justify-start relative group">
                <div class="absolute inset-0 bg-orange-100 rounded-3xl blur-3xl opacity-40 group-hover:opacity-60 transition duration-500"></div>
                <!-- Menggunakan gambar Pura Ulun Danu Bratan yang ikonik & premium -->
                <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=1000&q=80" 
                     alt="Ilustrasi Bali modern" 
                     class="relative w-full h-[350px] lg:h-[450px] object-cover rounded-3xl shadow-2xl transform hover:scale-[1.02] transition duration-500 ease-in-out" />
            </div>

            <!-- Kanan: Heading Text & CTA -->
            <div class="order-1 lg:order-2 text-center lg:text-left z-10">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-50 border border-orange-100 text-orange-600 text-xs font-bold tracking-widest uppercase mb-6">
                    <span class="w-2 h-2 rounded-full bg-orange-500 animate-pulse"></span>
                    Inovasi Digital Bali
                </div>
                <h1 class="text-5xl lg:text-7xl font-black text-gray-900 tracking-tight leading-tight mb-6">
                    Membangun Desa <br />
                    <span class="bg-gradient-to-r from-amber-500 to-orange-600 bg-clip-text text-transparent">Lebih Cerdas.</span>
                </h1>
                <p class="text-lg text-gray-500 mb-10 max-w-xl mx-auto lg:mx-0 leading-relaxed font-medium">
                    SI-MADE mengintegrasikan pelayanan publik, manajemen data, dan transparansi desa dalam satu platform digital yang mudah diakses oleh seluruh warga.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="/login" class="inline-flex justify-center items-center px-8 py-4 text-base font-bold text-white bg-gradient-to-r from-amber-500 to-orange-600 rounded-2xl shadow-lg shadow-orange-200 hover:shadow-orange-300 hover:-translate-y-1 transition-all duration-300">
                        Login Penduduk
                        <svg class="w-5 h-5 ml-2 -mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </a>
                </div>
            </div>

        </div>
    </section>

    <!-- page 2 -->
    <section class="bg-slate-50 border-y border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                
                <div>
                    <h2 class="text-3xl lg:text-4xl font-extrabold text-gray-900 tracking-tight mb-6">
                        Menyatukan Tradisi & <br/> Inovasi Teknologi
                    </h2>
                    <div class="space-y-6 text-gray-600 leading-relaxed text-lg">
                        <p>
                            Sistem Informasi Manajemen Desa (SI-MADE) lahir sebagai solusi untuk menjembatani kearifan lokal dengan efisiensi teknologi modern. Kami hadir untuk memangkas birokrasi yang rumit menjadi lebih transparan dan cepat.
                        </p>
                        <div class="pl-4 border-l-4 border-orange-500">
                            <h4 class="font-bold text-gray-900 mb-1">Tujuan Utama Kami</h4>
                            <p class="text-sm">Mewujudkan tata kelola desa yang akuntabel, di mana setiap warga memiliki hak akses penuh terhadap informasi, layanan surat, hingga distribusi logistik desa secara *real-time*.</p>
                        </div>
                    </div>
                </div>

                <div class="relative rounded-3xl overflow-hidden shadow-2xl group">
                    <img src="https://images.unsplash.com/photo-1604999333679-b86d54738315?auto=format&fit=crop&w=1000&q=80" 
                         alt="Perkumpulan Masyarakat Bali Bergotong Royong" 
                         class="w-full h-[400px] object-cover group-hover:scale-105 transition-transform duration-700" />
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900/60 to-transparent"></div>
                    <div class="absolute bottom-6 left-6 right-6">
                        <p class="text-white font-bold text-lg">Semangat Menyama Braya</p>
                        <p class="text-white/80 text-sm">Kolaborasi warga dalam menjaga nilai adat dan membangun desa bersama.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- page 3 -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Layanan Unggulan Desa</h2>
            <p class="mt-4 text-gray-500 text-lg">Infrastruktur digital terintegrasi untuk melayani segala kebutuhan administrasi dan penyaluran desa.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center text-2xl mb-6">📦</div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Inventaris Desa</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Pencatatan dan pemantauan seluruh aset serta barang inventaris milik desa secara akurat dan transparan.</p>
            </div>

            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl mb-6">🌾</div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Lumbung Desa</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Manajemen distribusi logistik dan bantuan sosial agar tersalurkan secara adil dan tercatat rapi dalam sistem.</p>
            </div>

            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                <div class="w-14 h-14 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center text-2xl mb-6">📄</div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Pengajuan Surat</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Cetak surat pengantar, keterangan domisili, atau keperluan kemahasiswaan dari rumah tanpa perlu antre di balai.</p>
            </div>

            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                <div class="w-14 h-14 bg-red-50 text-red-600 rounded-2xl flex items-center justify-center text-2xl mb-6">📣</div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Pengaduan Warga</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Kanal pelaporan infrastruktur rusak, keamanan, hingga saran pembangunan yang langsung terhubung ke perbekel.</p>
            </div>
        </div>

        <!-- page logo kabbs -->
        <div class="mt-32 border-t border-gray-100 pt-16">
            <p class="text-center text-sm font-bold text-gray-400 uppercase tracking-widest mb-10">Telah Siap Diimplementasikan di 9 Kabupaten/Kota Bali</p>
            
            <div class="grid grid-cols-3 md:grid-cols-5 lg:grid-cols-9 gap-6 items-center">
                
                <div class="flex flex-col items-center gap-2 group opacity-60 grayscale hover:opacity-100 hover:grayscale-0 transition duration-300">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center p-1 group-hover:scale-110 transition duration-300">
                        <img src="{{ asset('image/9_kabupaten/badung.png') }}" alt="Logo Badung" class="w-full h-full object-contain">
                    </div>
                    <span class="text-[10px] font-bold text-gray-500 tracking-wider">Badung</span>
                </div>

                <div class="flex flex-col items-center gap-2 group opacity-60 grayscale hover:opacity-100 hover:grayscale-0 transition duration-300">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center p-1 group-hover:scale-110 transition duration-300">
                        <img src="{{ asset('image/9_kabupaten/bangli.png') }}" alt="Logo Bangli" class="w-full h-full object-contain">
                    </div>
                    <span class="text-[10px] font-bold text-gray-500 tracking-wider">Bangli</span>
                </div>

                <div class="flex flex-col items-center gap-2 group opacity-60 grayscale hover:opacity-100 hover:grayscale-0 transition duration-300">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center p-1 group-hover:scale-110 transition duration-300">
                        <img src="{{ asset('image/9_kabupaten/buleleng.png') }}" alt="Logo Buleleng" class="w-full h-full object-contain">
                    </div>
                    <span class="text-[10px] font-bold text-gray-500 tracking-wider">Buleleng</span>
                </div>

                <div class="flex flex-col items-center gap-2 group opacity-60 grayscale hover:opacity-100 hover:grayscale-0 transition duration-300">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center p-1 group-hover:scale-110 transition duration-300">
                        <img src="{{ asset('image/9_kabupaten/denpasar.png') }}" alt="Logo Denpasar" class="w-full h-full object-contain">
                    </div>
                    <span class="text-[10px] font-bold text-gray-500 tracking-wider">Denpasar</span>
                </div>

                <div class="flex flex-col items-center gap-2 group opacity-60 grayscale hover:opacity-100 hover:grayscale-0 transition duration-300">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center p-1 group-hover:scale-110 transition duration-300">
                        <img src="{{ asset('image/9_kabupaten/gianyar.png') }}" alt="Logo Gianyar" class="w-full h-full object-contain">
                    </div>
                    <span class="text-[10px] font-bold text-gray-500 tracking-wider">Gianyar</span>
                </div>

                <div class="flex flex-col items-center gap-2 group opacity-60 grayscale hover:opacity-100 hover:grayscale-0 transition duration-300">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center p-1 group-hover:scale-110 transition duration-300">
                        <img src="{{ asset('image/9_kabupaten/jembrana.png') }}" alt="Logo Jembrana" class="w-full h-full object-contain">
                    </div>
                    <span class="text-[10px] font-bold text-gray-500 tracking-wider">Jembrana</span>
                </div>

                <div class="flex flex-col items-center gap-2 group opacity-60 grayscale hover:opacity-100 hover:grayscale-0 transition duration-300">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center p-1 group-hover:scale-110 transition duration-300">
                        <img src="{{ asset('image/9_kabupaten/karangasem.png') }}" alt="Logo Karangasem" class="w-full h-full object-contain">
                    </div>
                    <span class="text-[10px] font-bold text-gray-500 tracking-wider">Karangasem</span>
                </div>

                <div class="flex flex-col items-center gap-2 group opacity-60 grayscale hover:opacity-100 hover:grayscale-0 transition duration-300">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center p-1 group-hover:scale-110 transition duration-300">
                        <img src="{{ asset('image/9_kabupaten/klungkung.png') }}" alt="Logo Klungkung" class="w-full h-full object-contain">
                    </div>
                    <span class="text-[10px] font-bold text-gray-500 tracking-wider">Klungkung</span>
                </div>

                <div class="flex flex-col items-center gap-2 group opacity-60 grayscale hover:opacity-100 hover:grayscale-0 transition duration-300">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center p-1 group-hover:scale-110 transition duration-300">
                        <img src="{{ asset('image/9_kabupaten/tabanan.png') }}" alt="Logo Tabanan" class="w-full h-full object-contain">
                    </div>
                    <span class="text-[10px] font-bold text-gray-500 tracking-wider">Tabanan</span>
                </div>

            </div>
        </div>
    </section>


    <footer class="bg-gray-900 border-t border-gray-800 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="md:col-span-2">
                    <div class="flex items-center gap-2.5 mb-4">
                        <div class="w-8 h-8 bg-gradient-to-br from-amber-500 to-orange-600 rounded-lg flex items-center justify-center text-white font-extrabold text-sm">M</div>
                        <span class="text-lg font-black text-white tracking-tight">SI-MADE</span>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed max-w-sm">
                        Sistem Informasi Manajemen Desa terbaik untuk mendukung pelayanan publik, transparansi, dan efisiensi birokrasi desa di seluruh penjuru Bali.
                    </p>
                </div>
                
                <div>
                    <h4 class="text-white font-bold mb-4 uppercase text-xs tracking-wider">Layanan</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-orange-500 transition">Inventaris</a></li>
                        <li><a href="#" class="hover:text-orange-500 transition">Lumbung Desa</a></li>
                        <li><a href="#" class="hover:text-orange-500 transition">Pengajuan Surat</a></li>
                        <li><a href="#" class="hover:text-orange-500 transition">Pengaduan Warga</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-bold mb-4 uppercase text-xs tracking-wider">Hubungi Kami</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li>Tim Pengembang SI-MADE</li>
                        <li>Bali, Indonesia</li>
                        <li><a href="mailto:halo@simade.id" class="hover:text-orange-500 transition">halo@simade.id</a></li>
                    </ul>
                </div>
            </div>

            <!-- Copyright Line -->
            <!-- <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-gray-500 text-xs">
                    &copy; 2026 SI-MADE. Hak Cipta Dilindungi Undang-Undang.
                </p>
                <p class="text-gray-500 text-xs flex items-center gap-1">
                    Dikembangkan dengan <span class="text-red-500">❤️</span> oleh <span class="font-bold text-white hover:text-orange-500 cursor-pointer">myteam</span>
                </p>
            </div> -->
        </div>
    </footer>

</div>