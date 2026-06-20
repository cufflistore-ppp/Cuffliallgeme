<?php
include 'config.php';

// Ambil data dari Tripay
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Verifikasi tanda tangan
$kode = $data['merchant_ref'] ?? '';
$status = $data['status'] ?? '';
$tanda_tangan = $data['signature'] ?? '';

$tanda_benar = hash_hmac('sha256', $kode . RAHASIA_API, RAHASIA_API);

if ($tanda_tangan === $tanda_benar && $status == 'PAID') {
    // Update status transaksi
    mysqli_query($conn, "UPDATE transaksi_saldo SET status = 'berhasil' WHERE referensi = '$kode'");
    
    // Tambah saldo pengguna
    $ambil = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id_pengguna, jumlah FROM transaksi_saldo WHERE referensi = '$kode'"));
    if ($ambil) {
        mysqli_query($conn, "UPDATE pengguna SET saldo = saldo + '{$ambil['jumlah']}' WHERE id = '{$ambil['id_pengguna']}'");
    }
    
    echo "OK";
} else {
    echo "Gagal verifikasi";
}
?>
