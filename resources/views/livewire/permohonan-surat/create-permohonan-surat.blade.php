<div style="background: #ffffff; padding: 24px; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
    
    @if (session()->has('message'))
        <div style="background-color: #10b981; color: white; padding: 12px; border-radius: 8px; margin-bottom: 16px;">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="kirimPermohonan">
        <h3 style="font-weight: bold; color: #1e293b; margin-bottom: 20px;">🔸 FORMULIR PERMOHONAN SURAT</h3>

        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 20px;">
            <!-- Pilih Jenis Surat -->
            <div>
                <label style="font-weight: 600; font-size: 0.875rem; color: #475569;">Pilih Jenis Surat *</label>
                <select wire:model.live="jenis_surat_id" style="width: 100%; margin-top: 6px; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px;" required>
                    <option value="">-- Pilih Jenis Surat --</option>
                    @foreach($daftarJenisSurat as $surat)
                        <option value="{{ $surat->id }}">{{ $surat->nama_surat }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Keperluan -->
            <div>
                <label style="font-weight: 600; font-size: 0.875rem; color: #475569;">Keperluan / Alasan Pengajuan *</label>
                <input type="text" wire:model="keperluan" style="width: 100%; margin-top: 6px; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px;" placeholder="Contoh: Syarat membuat KUR" required>
            </div>
        </div>

        <!-- ================================================================= -->
        <!-- 🌟 FORM DINAMIS: OTOMATIS MUNCUL JIKA WARGA MEMILIH OPSI SKU 🌟 -->
        <!-- ================================================================= -->
        @if($currentSlug === 'surat-keterangan-usaha-sku')
            <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; margin-bottom: 20px;">
                <h4 style="font-weight: 700; font-size: 0.85rem; color: #0f172a; margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.05em;">
                    📋 Detail Informasi Usaha Resmi (SKU)
                </h4>
                
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px;">
                    <div>
                        <label style="font-size: 0.75rem; font-weight: 700; color: #475569;">Nama Usaha *</label>
                        <input type="text" wire:model="data_kustom.nama_usaha" style="width: 100%; margin-top: 4px; padding: 8px; border: 1px solid #cbd5e1; border-radius: 6px;" placeholder="Contoh: Toko Sembako Melati" required>
                    </div>
                    
                    <div>
                        <label style="font-size: 0.75rem; font-weight: 700; color: #475569;">Jenis Usaha / Sektor *</label>
                        <input type="text" wire:model="data_kustom.jenis_usaha" style="width: 100%; margin-top: 4px; padding: 8px; border: 1px solid #cbd5e1; border-radius: 6px;" placeholder="Contoh: Perdagangan Sembako" required>
                    </div>
                    
                    <div style="grid-column: span 2;">
                        <label style="font-size: 0.75rem; font-weight: 700; color: #475569;">Alamat Lengkap Fisik Usaha *</label>
                        <input type="text" wire:model="data_kustom.alamat_usaha" style="width: 100%; margin-top: 4px; padding: 8px; border: 1px solid #cbd5e1; border-radius: 6px;" placeholder="Contoh: Banjar Dinas Semeton, Desa Badung" required>
                    </div>
                </div>
            </div>

            <!-- Upload Persyaratan Khusus SKU -->
            <div style="border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; margin-bottom: 20px;">
                <p style="font-weight: 600; font-size: 0.85rem; color: #334155; margin-bottom: 12px;">📎 Unggah Dokumen Persyaratan Wajib (Maks. 2MB)</p>
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px;">
                    <div>
                        <label style="font-size: 0.75rem; font-weight: 700; color: #475569;">Foto Fisik Tempat Usaha *</label>
                        <input type="file" wire:model="foto_usaha" style="margin-top: 4px;" required>
                    </div>
                    <div>
                        <label style="font-size: 0.75rem; font-weight: 700; color: #475569;">Nota Pembelian Bahan Usaha *</label>
                        <input type="file" wire:model="nota_bahan" style="margin-top: 4px;" required>
                    </div>
                </div>
            </div>
        @endif

        <!-- Tombol Kirim -->
        <div style="text-align: right;">
            <button type="submit" style="background-color: #f97316; color: white; padding: 10px 24px; font-weight: bold; border-radius: 8px; border: none; cursor: pointer;">
                Kirim Pengajuan Surat
            </button>
        </div>
    </form>
</div>