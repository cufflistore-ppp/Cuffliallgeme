<?php
include 'config.php';
session_start();

// Cek sudah login
if (!isset($_SESSION['id_pengguna'])) {
    header('Location: login.php');
    exit;
}

$pesan = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jumlah = (int)$_POST['jumlah'];
    
    if ($jumlah < MINIMAL_SALDO) {
        $pesan = "<div style='padding:15px; background:#ffebee; color:#c62828; border-radius:5px; text-align:center;'>Minimal isi saldo Rp " . number_format(MINIMAL_SALDO) . "</div>";
    } else {
        $biaya_admin = BIAYA_ADMIN;
        $total_bayar = $jumlah + $biaya_admin;
        $referensi = 'TOPUP-' . time() . '-' . $_SESSION['id_pengguna'];
        
        // Nanti bagian ini diganti dengan kode API Tripay
        // Contoh tampilan sementara
        $kode_qr = "https://via.placeholder.com/250?text=QRIS+PEMBAYARAN\nJumlah+Rp" . number_format($total_bayar);
        
        $simpan = mysqli_query($conn, "INSERT INTO transaksi_saldo 
                    (id_pengguna, jumlah, biaya_admin, total_bayar, kode_qr, referensi, status)
                    VALUES ('{$_SESSION['id_pengguna']}', '$jumlah', '$biaya_admin', '$total_bayar', '$kode_qr', '$referensi', 'menunggu')");
        
        if ($simpan) {
            $pesan = "
            <div style='padding:20px; background:#e3f2fd; border-radius:8px; text-align:center;'>
                <h4>Silakan Lakukan Pembayaran</h4>
                <p>Jumlah Isi: Rp " . number_format($jumlah) . "</p>
                <p>Biaya Admin: Rp " . number_format($biaya_admin) . "</p>
                <h3>Total Bayar: Rp " . number_format($total_bayar) . "</h3>
                <img src='$kode_qr' alt='QRIS' style='width:250px; margin:15px 0;'>
                <p>Referensi: <b>$referensi</b></p>
                <p>Bayar dalam waktu 1x24 jam. Saldo akan otomatis masuk setelah pembayaran terkonfirmasi.</p>
                <p>Butuh bantuan? <a href='https://wa.me/" . WA_ADMIN1 . "' target='_blank'>Hubungi Admin</a></p>
            </div>";
        } else {
            $pesan = "<div style='padding:15px; background:#ffebee; color:#c62828; border-radius:5px; text-align:center;'>Gagal membuat transaksi, coba lagi</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Isi Saldo - CUFFLI STORE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        *{font-family:Arial; margin:0; padding:0; box-sizing:border-box;}
        body{background:#f8f9fa;}
        header{background:#2c3e50; color:white; padding:18px; text-align:center;}
        nav{background:#fff; padding:12px; box-shadow:0 2px 4px #ddd; text-align:center; position:sticky; top:0; z-index:99;}
        nav a{margin:0 12px; text-decoration:none; color:#333; font-weight:bold; padding:8px 12px; border-radius:5px;}
        nav a:hover{background:#f0f0f0;}
        .wa-btn{background:#25d366; color:white !important;}
        .btn-red{background:#d32f2f; color:white !important;}
        .container{max-width:500px; margin:20px auto; padding:15px;}
        .card{background:white; padding:25px; border-radius:8px; box-shadow:0 2px 5px #ddd;}
        h2{text-align:center; color:#2c3e50; margin-bottom:20px;}
        .form-group{margin-bottom:18px;}
        label{display:block; margin-bottom:8px; font-weight:bold; color:#333;}
        input{width:100%; padding:13px; border:1px solid #ddd; border-radius:5px; font-size:16px;}
        .btn{width:100%; padding:14px; background:#25d366; color:white; border:none; border-radius:5px; font-weight:bold; font-size:16px; cursor:pointer;}
        .info{font-size:14px; color:#666; margin-top:10px; text-align:center;}
    </style>
</head>
<body>
    <header>
        <h1>💳 Isi Saldo</h1>
    </header>
    <nav>
        <a href="index.php">Beranda</a>
        <a href="produk.php">Produk</a>
        <a href="membership.php">Membership</a>
        <a href="isi-saldo.php" class="btn-red">Isi Saldo</a>
        <a href="https://wa.me/<?= WA_ADMIN1 ?>" target="_blank" class="wa-btn">WA Admin</a>
        <a href="saldo.php">Saldo: Rp <?= number_format($_SESSION['saldo'] ?? 0) ?></a>
        <a href="logout.php">Keluar</a>
    </nav>

    <div class="container">
        <div class="card">
            <h2>Isi Saldo Akun</h2>
            
            <?= $pesan ?>
            
            <?php if (empty($pesan) || strpos($pesan, 'minimal') !== false): ?>
            <form method="post">
                <div class="form-group">
                    <label>Jumlah Isi Saldo (Rp)</label>
                    <input type="number" name="jumlah" min="<?= MINIMAL_SALDO ?>" placeholder="Contoh: 10000, 20000, dst" required>
                    <p class="info">*Minimal isi Rp <?= number_format(MINIMAL_SALDO) ?> + biaya admin Rp <?= number_format(BIAYA_ADMIN) ?></p>
                </div>
                <button type="submit" class="btn">Buat Pembayaran QRIS</button>
            </form>
            <?php endif; ?>
            
            <div style="text-align:center; margin-top:20px;">
                <a href="index.php" style="color:#1976d2; text-decoration:none;">← Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</body>
</html>
