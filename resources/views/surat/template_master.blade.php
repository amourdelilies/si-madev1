<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Resmi Desa Badung</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11pt; color: #000; line-height: 1.5; }
        .kop-surat { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 25px; }
        .kop-surat h3 { margin: 0; text-transform: uppercase; font-size: 12pt; font-weight: bold; }
        .kop-surat h2 { margin: 2px 0; text-transform: uppercase; font-size: 14pt; font-weight: bold; }
        .kop-surat h1 { margin: 0; text-transform: uppercase; font-size: 16pt; font-weight: bold; }
        .kop-surat p { margin: 4px 0 0 0; font-size: 9pt; font-style: italic; }
        .judul-surat { text-align: center; margin-bottom: 25px; }
        .judul-surat h4 { margin: 0; text-transform: uppercase; font-size: 12pt; font-weight: bold; text-decoration: underline; }
        .judul-surat p { margin: 3px 0 0 0; font-size: 10pt; font-family: monospace; }
        .tabel-data { width: 100%; margin-bottom: 20px; border-collapse: collapse; }
        .tabel-data td { padding: 4px 0; vertical-align: top; }
        .blok-kustom { margin: 20px 0; text-align: justify; }
        .tanda-tangan { float: right; width: 45%; text-align: center; margin-top: 20px; }
        .tte-box { margin: 10px auto; padding: 6px; border: 1px solid #000; width: 110px; text-align: center; font-size: 8pt; font-family: monospace; }
    </style>
</head>
<body>

    <div class="kop-surat">
        <h3>PEMERINTAH KABUPATEN BADUNG</h3>
        <h2>KECAMATAN KUTA SELATAN</h2>
        <h1>KANTOR KEPALA DESA BADUNG</h1>
        <p>Jl. Raya Kampus Unud, Bukit Jimbaran, Badung, Bali - 80361</p>
    </div>

    <div class="judul-surat">
        <h4>{{ $record->jenisSurat->nama_surat ?? $record->jenis_surat }}</h4>
        <p>Nomor: {{ $nomor_surat }}</p>
    </div>

    <p>Yang bertanda tangan di bawah ini Kepala Desa Badung, Kecamatan Kuta Selatan, Kabupaten Badung, menerangkan dengan sebenarnya bahwa:</p>
    
    <table class="tabel-data">
        <tr><td style="width: 30%;">Nama Lengkap</td><td style="width: 3%;">:</td><td style="font-weight: bold;">{{ $warga->nama_lengkap ?? '-' }}</td></tr>
        <tr><td>NIK / No. KTP</td><td>:</td><td style="font-family: monospace;">{{ $warga->nik ?? '-' }}</td></tr>
        <tr><td>Tempat, Tgl Lahir</td><td>:</td><td>{{ $warga->tempat_lahir ?? '-' }}, {{ $warga->tanggal_lahir ?? '-' }}</td></tr>
        <tr><td>Pekerjaan</td><td>:</td><td>{{ $warga->pekerjaan ?? '-' }}</td></tr>
        <tr><td>Alamat Domisili</td><td>:</td><td>{{ $warga->alamat ?? '-' }}</td></tr>
    </table>

    <div class="blok-kustom">
        
        <!-- 1. BLOK TEMPLATE: SKU (Surat Keterangan Usaha) -->
        @if(str_contains(strtolower($record->jenisSurat->nama_surat ?? $record->jenis_surat), 'usaha') || str_contains(strtolower($record->jenisSurat->slug ?? ''), 'sku'))
            <p>Berdasarkan pernyataan dari yang bersangkutan, benar bahwa nama tersebut di atas memiliki kegiatan usaha mikro/kecil yang bertempat di wilayah Desa Badung dengan rincian operasional sebagai berikut:</p>
            <table style="width: 100%; margin-left: 15px; margin-top: 10px;">
                <tr>
                    <td style="width: 30%; font-weight: bold;">Nama Usaha</td>
                    <td style="width: 3%;">:</td>
                    <!-- Multi-key check: Menangani variasi penamaan input database -->
                    <td>{{ $data_surat['nama_usaha'] ?? $data_surat['Nama Usaha'] ?? $data_surat['nama_toko'] ?? $data_surat['namaUsaha'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Jenis / Sektor Usaha</td>
                    <td>:</td>
                    <td>{{ $data_surat['jenis_usaha'] ?? $data_surat['Jenis Usaha'] ?? $data_surat['bidang_usaha'] ?? $data_surat['jenisUsaha'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Tanggal Mulai Usaha</td>
                    <td>:</td>
                    <td>
                        @php
                            $tanggalUsaha = $data_surat['lama_usaha'] ?? $data_surat['Lama Usaha'] ?? $data_surat['tanggal_mulai_usaha'] ?? $data_surat['tanggal_usaha'] ?? null;
                        @endphp
                        {{ $tanggalUsaha ? \Carbon\Carbon::parse($tanggalUsaha)->translatedFormat('d F Y') : '-' }}
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Alamat Tempat Usaha</td>
                    <td>:</td>
                    <td>{{ $data_surat['alamat_usaha'] ?? $data_surat['Alamat Usaha'] ?? $data_surat['alamat_tempat_usaha'] ?? $data_surat['alamatUsaha'] ?? '-' }}</td>
                </tr>
            </table>

        <!-- 2. BLOK TEMPLATE: SKTM (Tidak Mampu) -->
        @elseif(str_contains(strtolower($record->jenisSurat->nama_surat ?? $record->jenis_surat), 'mampu') || str_contains(strtolower($record->jenisSurat->slug ?? ''), 'sktm'))
            <p>Menerangkan bahwa keluarga bersangkutan terdata di database desa tergolong sebagai keluarga kurang mampu/ekonomi lemah. Surat keterangan ini diterbitkan secara sah atas permohonan bersangkutan guna keperluan penunjang administratif: <strong>{{ $data_surat['peruntukan_sktm'] ?? $data_surat['Peruntukan SKTM'] ?? $data_surat['keperluan_sktm'] ?? '-' }}</strong>.</p>

        <!-- 3. BLOK TEMPLATE: SKCK / Kelakuan Baik -->
        @elseif(str_contains(strtolower($record->jenisSurat->nama_surat ?? $record->jenis_surat), 'skck') || str_contains(strtolower($record->jenisSurat->nama_surat ?? $record->jenis_surat), 'kelakuan'))
            <p>Menerangkan bahwa sepanjang pengamatan administrasi lingkungan desa, orang tersebut di atas dikenal berkelakuan baik dan tidak sedang tersangkut perkara pidana. Surat pengantar ini diterbitkan resmi untuk keperluan persyaratan: <strong>{{ $data_surat['peruntukan_skck'] ?? $data_surat['Peruntukan SKCK'] ?? $data_surat['keperluan_skck'] ?? '-' }}</strong>.</p>

        <!-- 4. BLOK TEMPLATE: KELAHIRAN -->
        @elseif(str_contains(strtolower($record->jenisSurat->nama_surat ?? $record->jenis_surat), 'lahir'))
            <p>Menerangkan dengan sebenarnya bahwa telah lahir seorang anak dari pasangan suami-istri sah dengan rincian kelahiran:</p>
            <table style="width: 100%; margin-left: 15px; margin-top: 10px;">
                <tr>
                    <td style="width: 30%; font-weight: bold;">Nama Bayi</td>
                    <td style="width: 3%;">:</td>
                    <td style="font-weight: bold;">{{ $data_surat['nama_bayi'] ?? $data_surat['Nama Bayi'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Tanggal / Tempat Lahir</td>
                    <td>:</td>
                    <td>
                        @php
                            $tglBayi = $data_surat['tanggal_lahir_bayi'] ?? $data_surat['Tanggal Lahir Bayi'] ?? null;
                        @endphp
                        {{ $tglBayi ? \Carbon\Carbon::parse($tglBayi)->translatedFormat('d F Y') : '-' }} / {{ $data_surat['tempat_lahir_bayi'] ?? $data_surat['Tempat Lahir Bayi'] ?? '-' }}
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Identitas Orang Tua</td>
                    <td>:</td>
                    <td>Ayah: {{ $data_surat['nama_ayah'] ?? $data_surat['Nama Ayah'] ?? '-' }} | Ibu: {{ $data_surat['nama_ibu'] ?? $data_surat['Nama Ibu'] ?? '-' }}</td>
                </tr>
            </table>

        <!-- 5. JALUR CADANGAN: Jika ada jenis surat lain / tidak masuk kriteria di atas -->
        @else
            <p>Menerangkan bahwa surat keterangan pengantar administrasi desa ini diberikan kepada yang bersangkutan secara resmi guna memenuhi kelengkapan berkas: <strong>{{ $record->keperluan }}</strong>.</p>
        @endif
        
        <p style="margin-top: 20px;">Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya dan penuh tanggung jawab.</p>
    </div>

    <!-- 🌟 SIGNATURE BLOCK DENGAN INTEGRASI TTE DIGITAL QR CODE -->
    <div class="tanda-tangan">
        <p>Badung, {{ $tanggal_cetak }}</p>
        <p style="font-weight: bold; margin-bottom: 5px;">Kepala Desa Badung</p>
        
        <!-- Kotak Representasi Dokumen Ter-TTE Elektronik -->
        <div class="tte-box">
            <span style="font-weight: bold; color: #1e3a8a;">DITANDATANGANI<br>SECARA ELEKTRONIK</span><br>
            <span style="font-size: 6.5pt; color: #555;">ID Dokumen:<br>{{ md5($nomor_surat) }}</span>
        </div>

        <p style="font-weight: bold; text-decoration: underline; text-transform: uppercase; margin-top: 5px;">I Gede Sukarja, S.Kom.</p>
        <p style="font-size: 8pt; font-family: monospace; margin-top: 2px;">NIP. 19881210 202607 1 002</p>
    </div>

</body>
</html>