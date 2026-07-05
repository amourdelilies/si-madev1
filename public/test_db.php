<?php
// Silakan samakan nilai di bawah ini dengan isi file .env kamu saat ini
$host = '127.0.0.1';
$user = 'root';
$pass = ''; // isi 'root' jika kamu menggunakan MAMP
$db   = 'si_made_v1';
$port = '3306'; // ganti ke 8889 jika kamu menggunakan MAMP

echo "<h3>Memulai Tes Koneksi Database...</h3>";

// 1. Tes koneksi ke server MySQL
$conn = @mysqli_connect($host, $user, $pass, '', $port);
if (!$conn) {
    die("<b style='color:red'>Gagal Terhubung ke MySQL Server!</b> Error: " . mysqli_connect_error() . "<br><i>Solusi: Periksa kembali apakah MySQL sudah menyala, port sudah benar, atau password user 'root' perlu diisi.</i>");
}
echo "<b style='color:green'>Sip! Sukses Terhubung ke MySQL Server.</b><br><br>";

// 2. Tes memilih database si_made_v1
if (!@mysqli_select_db($conn, $db)) {
    die("<b style='color:red'>Gagal Menemukan Database [ $db ]!</b><br><i>Solusi: Database belum terbuat di phpMyAdmin. Silakan buat database baru bernama '$db' terlebih dahulu lewat localhost/phpmyadmin.</i>");
}
echo "<b style='color:green'>Sip! Database [ $db ] Berhasil Ditemukan.</b><br><br>";

// 3. Tes cek tabel inventaris
$check_table = mysqli_query($conn, "SHOW TABLES LIKE 'inventaris'");
if (mysqli_num_rows($check_table) == 0) {
    die("<b style='color:red'>Tabel 'inventaris' belum ada!</b><br><i>Solusi: Kamu belum menjalankan perintah 'php artisan migrate' di terminal proyek ini.</i>");
}
echo "<b style='color:green'>Sip! Tabel 'inventaris' tersedia di database.</b><br><br>";

echo "<h4 style='color:blue'>Kesimpulan: Koneksi MySQL dasar aman. Masalah kemungkinan besar hanya pada konfigurasi cache Laravel.</h4>";