<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Stiker Label Aset - {{ $item->kode_barang }}</title>
    <style>
        @page {
            margin: 0;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            margin: 0;
            padding: 10px;
            background-color: #fff;
            color: #333;
        }
        /* Kotak Stiker Ukuran 10cm x 5cm */
        .sticker-box {
            border: 2px dashed #1e293b;
            border-radius: 6px;
            padding: 8px;
            height: 120px;
            position: relative;
            background: #fff;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #1e293b;
            padding-bottom: 4px;
            margin-bottom: 8px;
        }
        .header h2 {
            font-size: 11px;
            margin: 0;
            text-transform: uppercase;
            color: #0f172a;
            letter-spacing: 0.5px;
        }
        .header p {
            font-size: 7px;
            margin: 2px 0 0 0;
            color: #64748b;
        }
        
        /* Container QR Code */
        .qr-container {
            position: absolute;
            left: 10px;
            top: 45px;
            width: 65px;
            height: 65px;
        }
        .qr-container img {
            width: 100%;
            height: 100%;
        }
        
        /* Sisi Kanan: Spesifikasi Fisik Aset */
        .details-container {
            margin-left: 85px;
            margin-top: 2px;
        }
        .details-container table {
            width: 100%;
            border-collapse: collapse;
        }
        .details-container td {
            font-size: 8.5px;
            padding: 2px 0;
            vertical-align: top;
        }
        .label-title {
            font-weight: bold;
            color: #475569;
            width: 60px;
        }
        .kode-badge {
            display: inline-block;
            background: #0f172a;
            color: #ffffff;
            padding: 2px 5px;
            font-weight: bold;
            border-radius: 3px;
            font-size: 7.5px;
            margin-top: 5px;
        }
    </style>
</head>
<body>

    <div class="sticker-box">
        <div class="header">
            <h2>Sistem Informasi Manajemen Aset Desa</h2>
            <p>Pemerintah Kabupaten Badung • Proyek SI-MADE</p>
        </div>

        <div class="qr-container">
            @php
                // Kita generate QR Code dalam bentuk string SVG biasa (tidak butuh imagick)
                $qrString = QrCode::size(65)->generate(url('/admin/inventaris-desa/' . $item->id));
                // Lalu kita ubah string tersebut menjadi format Base64 aman yang disukai DomPDF
                $base64Qr = base64_encode($qrString);
            @endphp
            <img src="data:image/svg+xml;base64,{{ $base64Qr }}" alt="QR Code Aset">
        </div>

        <div class="details-container">
            <table>
                <tr>
                    <td class="label-title">Barang</td>
                    <td>: <strong>{{ $item->nama_barang }}</strong></td>
                </tr>
                <tr>
                    <td class="label-title">Kategori</td>
                    <td>: {{ $item->kategori }}</td>
                </tr>
                <tr>
                    <td class="label-title">Lokasi</td>
                    <td>: {{ $item->lokasi }}</td>
                </tr>
                <tr>
                    <td class="label-title">Kondisi</td>
                    <td>: {{ strtoupper($item->kondisi) }}</td>
                </tr>
            </table>
            <div class="kode-badge">{{ $item->kode_barang }}</div>
        </div>
    </div>

</body>
</html>