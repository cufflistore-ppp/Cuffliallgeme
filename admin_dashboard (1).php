<?php
include '../config.php';
session_start();

// Cek hak akses
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

// Hitung data ringkasan
$total_pengguna = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pengguna"));
$total_produk = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM produk WHERE status = 'aktif'"));
$total_pesanan = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pesanan"));
$pesanan_baru = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pesanan WHERE status = 'diproses'"));
$pendapatan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total_bayar) AS total FROM pesanan WHERE status = 'selesai'"));
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin - CUFFLI STORE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        *{font-family:Arial; margin:0; padding:0; box-sizing:border-box;}
        body{background:#f8f9fa;}
        header{background:#2c3e50; color:white; padding:18px; text-align:center;}
        nav{background:white; padding:12px; box-shadow:0 2px 4px rgba(0,0,0,0.1); margin-bottom:20px;}
        nav a{display:inline-block; padding:10px 15px; margin:0 5px; text-decoration:none; color:#333; border-radius:5px;}
        nav a:hover{background:#e9ecef;}
        nav a.active{background:#1976d2; color:white;}
        .container{max-width:1100px; margin:0 auto; padding:15px;}
        .grid{display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:20px; margin-bottom:30px;}
        .card{background:white; padding:25px; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.08); text-align:center;}
        .card h3{font-size:16px; color:#666; margin-bottom:10px;}
        .card .angka{font-size:28px; font-weight:bold; color:#2c3e50; margin-bottom:5px;}
        .card.pendapatan{border-top:4px solid #28a745;}
        .card.pengguna{border-top:4px solid #17a2b8;}
        .card.produk{border-top:4px solid #ffc107;}
        .card.pesanan{border-top:4px solid #dc3545;}
    </style>
</head>
<body>
    <header>
        <h1>🛠️ DASHBOARD ADMIN</h1>
    </header>

    <nav>
        <a href="dashboard.php" class="active">Beranda</a>
        <a href="atur-produk.php">Kelola Produk</a>
        <a href="atur-pengumuman.php">Pengumuman</a>
        <a href="atur-biaya.php">Pengaturan</a>
        <a href="laporan.php">Laporan</a>
        <a href="logout.php" style="color:#dc3545; float:right;">Keluar</a>
    </nav>

    <div class="container">
        <div class="grid">
            <div class="card pengguna">
                <h3>Total Pengguna</h3>
                <div class="angka"><?= $total_pengguna ?></div>
                <p>Orang</p>
            </div>

            <div class="card produk">
                <h3>Produk Aktif</h3>
                <div class="angka"><?= $total_produk ?></div>
                <p>Jenis</p>
            </div>

            <div class="card pesanan">
                <h3>Pesanan Masuk</h3>
                <div class="angka"><?= $pesanan_baru ?></div>
                <p>Belum diproses</p>
            </div>

            <div class="card pendapatan">
                <h3>Total Pendapatan</h3>
                <div class="angka">Rp <?= number_format($pendapatan['total'] ?? 0) ?></div>
                <p>Dari pesanan selesai</p>
            </div>
        </div>
    </div>
</body>
</html>
