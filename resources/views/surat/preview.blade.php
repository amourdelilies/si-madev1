<div style="font-family: Arial, sans-serif; color: #1e293b; padding: 10px; line-height: 1.6;">
    <!-- KOP SURAT PEMERINTAH KABUPATEN BADUNG -->
    <div style="text-align: center; border-bottom: 3px double #000; padding-bottom: 12px; margin-bottom: 20px;">
        <h3 style="margin: 0; text-transform: uppercase; font-size: 1.1rem; letter-spacing: 0.05em; font-weight: 800;">Pemerintah Kabupaten Badung</h3>
        <h2 style="margin: 2px 0; text-transform: uppercase; font-size: 1.3rem; font-weight: 900; color: #0f172a;">Kecamatan Kuta Selatan</h2>
        <h1 style="margin: 0; text-transform: uppercase; font-size: 1.4rem; font-weight: 900; color: #d97706;">Kantor Kepala Desa Badung</h1>
        <p style="margin: 4px 0 0 0; font-size: 0.75rem; color: #64748b; font-style: italic;">Jl. Raya Kampus Unud, Bukit Jimbaran, Badung, Bali - 80361</p>
    </div>

    <!-- JUDUL SURAT DINAMIS -->
    <div style="text-align: center; margin-bottom: 24px;">
        <h3 style="margin: 0; text-transform: uppercase; font-size: 1.1rem; font-weight: 800; text-decoration: underline;">
            {{ $record->jenisSurat->nama_surat ?? $record->jenis_surat }}
        </h3>
        <p style="margin: 2px 0 0 0; font-size: 0.8rem; font-family: monospace; color: #475569;">
            Nomor: 470 / {{ str_pad($record->id, 3, '0', STR_PAD_LEFT) }} / Pem-Des / {{ date('Y') }}
        </p>
    </div>

    <p style="font-size: 0.85rem; margin-bottom: 12px;">Yang bertanda tangan di bawah ini Kepala Desa Badung, Kecamatan Kuta Selatan, Kabupaten Badung, menerangkan dengan sebenarnya bahwa:</p>
    
    <!-- IDENTITAS WARGA -->
    <table style="width: 100%; font-size: 0.85rem; margin-bottom: 20px; border-collapse: collapse;">
        <tr>
            <td style="width: 30%; padding: 4px 0; font-weight: 600; color: #475569;">Nama Lengkap</td>
            <td style="width: 3%; padding: 4px 0;">:</td>
            <td style="font-weight: 700; color: #0f172a;">{{ $warga->nama_lengkap ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 4px 0; font-weight: 600; color: #475569;">NIK / No. KTP</td>
            <td style="padding: 4px 0;">:</td>
            <td style="font-family: monospace; font-size: 0.9rem; color: #334155;">{{ $warga->nik ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 4px 0; font-weight: 600; color: #475569;">Tempat, Tgl Lahir</td>
            <td style="padding: 4px 0;">:</td>
            <td>{{ $warga->tempat_lahir ?? '-' }}, {{ $warga->tanggal_lahir ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 4px 0; font-weight: 600; color: #475569;">Pekerjaan</td>
            <td style="padding: 4px 0;">:</td>
            <td>{{ $warga->pekerjaan ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 4px 0; font-weight: 600; color: #475569;">Alamat Domisili</td>
            <td style="padding: 4px 0;">:</td>
            <td style="line-height: 1.4;">{{ $warga->alamat ?? '-' }}</td>
        </tr>
    </table>

    <!-- KONTEN FORM DINAMIS BERDASARKAN HASIL DECODE JSON -->
    <div style="font-size: 0.85rem; background-color: #fff; border: 1px dashed #cbd5e1; padding: 16px; border-radius: 8px; margin-bottom: 24px;">
        
        @if($record->jenis_surat === 'Surat Keterangan Usaha (SKU)')
            <p style="margin-top: 0;">Berdasarkan pernyataan bersangkutan, memang benar memiliki kegiatan usaha mikro/kecil di wilayah Desa Badung dengan rincian sebagai berikut:</p>
            <table style="width: 100%; margin-left: 10px;">
                <tr>
                    <td style="width: 30%; padding: 3px 0; font-weight: 600;">Nama Usaha</td>
                    <td style="width: 3%;">:</td>
                    <td style="font-weight: 700; color: #b45309;">{{ $data_surat['nama_usaha'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 3px 0; font-weight: 600;">Bidang / Jenis Usaha</td>
                    <td>:</td>
                    <td>{{ $data_surat['jenis_usaha'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 3px 0; font-weight: 600;">Tanggal Mulai Usaha</td>
                    <td>:</td>
                    <td>{{ isset($data_surat['lama_usaha']) ? \Carbon\Carbon::parse($data_surat['lama_usaha'])->format('d F Y') : '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 3px 0; font-weight: 600;">Alamat Tempat Usaha</td>
                    <td>:</td>
                    <td>{{ $data_surat['alamat_usaha'] ?? '-' }}</td>
                </tr>
            </table>

        @elseif($record->jenis_surat === 'Surat Keterangan Tidak Mampu (SKTM)')
            <p style="margin-top: 0;">Menerangkan bahwa keluarga bersangkutan tergolong keluarga kurang mampu/ekonomi lemah. Surat keterangan ini dikeluarkan guna keperluan: <strong>{{ $data_surat['peruntukan_sktm'] ?? '-' }}</strong>.</p>

        @elseif($record->jenis_surat === 'Surat Pengantar SKCK')
            <p style="margin-top: 0;">Menerangkan bahwa orang tersebut di atas berkelakuan baik dan tidak pernah tersangkut perkara pidana. Surat pengantar ini diberikan untuk melengkapi persyaratan: <strong>{{ $data_surat['peruntukan_skck'] ?? '-' }}</strong>.</p>

        @elseif($record->jenis_surat === 'Surat Pindah')
            <p style="margin-top: 0;">Menerangkan bahwa yang bersangkutan mengajukan perpindahan domisili keluar dari Desa Badung dengan rincian:</p>
            <table style="width: 100%; margin-left: 10px;">
                <tr>
                    <td style="width: 30%; padding: 3px 0; font-weight: 600;">Alamat Tujuan</td>
                    <td style="width: 3%;">:</td>
                    <td>{{ $data_surat['alamat_tujuan'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 3px 0; font-weight: 600;">Alasan Pindah</td>
                    <td>:</td>
                    <td>{{ $data_surat['alasan_pindah'] ?? '-' }}</td>
                </tr>
            </table>

        @elseif($record->jenis_surat === 'Surat Keterangan Kematian')
            <p style="margin-top: 0;">Menerangkan bahwa telah meninggal dunia warga dengan identitas:</p>
            <table style="width: 100%; margin-left: 10px;">
                <tr>
                    <td style="width: 30%; padding: 3px 0; font-weight: 600;">Nama Almarhum</td>
                    <td style="width: 3%;">:</td>
                    <td>{{ $data_surat['nama_almarhum'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 3px 0; font-weight: 600;">Tanggal Meninggal</td>
                    <td>:</td>
                    <td>{{ isset($data_surat['tanggal_meninggal']) ? \Carbon\Carbon::parse($data_surat['tanggal_meninggal'])->format('d F Y') : '-' }}</td>
                </tr>
            </table>

        @elseif($record->jenis_surat === 'Surat Keterangan Kelahiran')
            <p style="margin-top: 0;">Menerangkan dengan sebenarnya bahwa telah lahir seorang anak:</p>
            <table style="width: 100%; margin-left: 10px;">
                <tr>
                    <td style="width: 30%; padding: 3px 0; font-weight: 600;">Nama Bayi</td>
                    <td style="width: 3%;">:</td>
                    <td>{{ $data_surat['nama_bayi'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 3px 0; font-weight: 600;">Nama Orang Tua (A/I)</td>
                    <td>:</td>
                    <td>{{ $data_surat['nama_ayah'] ?? '-' }} / {{ $data_surat['nama_ibu'] ?? '-' }}</td>
                </tr>
            </table>

        @else
            <p style="margin-top: 0;">Menerangkan bahwa dokumen ini dikeluarkan berdasarkan keperluan warga untuk memenuhi syarat: <strong>{{ $record->keperluan }}</strong>.</p>
        @endif
        
        <p style="margin-bottom: 0; margin-top: 12px; line-height: 1.5;">Demikian surat keterangan pengantar ini dibuat dengan sebenar-benarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
    </div>

    <!-- TANDA TANGAN -->
    <div style="float: right; width: 35%; text-align: center; font-size: 0.85rem; margin-top: 10px;">
        <p style="margin: 0;">Badung, {{ date('d F Y') }}</p>
        <p style="margin: 2px 0 0 0; font-weight: bold;">Kepala Desa Badung</p>
        <div style="height: 55px;"></div>
        <p style="margin: 0; font-weight: 900; text-decoration: underline; text-transform: uppercase;">I Gede Sukarja, S.Kom.</p>
        <p style="margin: 0; font-size: 0.75rem; color: #64748b; font-family: monospace;">NIP. 19881210 202607 1 002</p>
    </div>
    <div style="clear: both;"></div>
</div>