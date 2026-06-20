<?php
// Pengaturan Dasar Toko
define('NAMA_TOKO', 'CUFFLI STORE');
define('MINIMAL_SALDO', 1000); // Minimal isi saldo Rp1.000
define('BIAYA_ADMIN', 500);     // Biaya admin per transaksi
define('RAHASIA_API', 'GANTI_DENGAN_KUNCI_RAHASIA_TRIPAY_NANTI');

// Kontak Admin
define('WA_ADMIN1', '6285138460161');
define('WA_ADMIN2', '62895352910438');

// Koneksi Database (nanti diganti sesuai data hosting)
$host = 'localhost';
$user = 'isi_username_hosting';
$pass = 'isi_password_hosting';
$db   = 'isi_nama_database';

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) die('Koneksi gagal: ' . mysqli_connect_error());

// Pengaturan Diskon Membership
$diskon = [
    'biasa'   => 0,    // 0% diskon
    'premium' => 15,   // 15% diskon
    'vip'     => 25    // 25% diskon
];
?>
