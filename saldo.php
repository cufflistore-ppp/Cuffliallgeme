<?php
include 'config.php';
session_start();

if (!isset($_SESSION['id_pengguna'])) {
    header('Location: login.php');
    exit;
}

// Ambil data pengguna
$id_pengguna = $_SESSION['id_pengguna'];
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pengguna WHERE id = '$id_pengguna'"));

// Ambil riwayat transaksi saldo
$riwayat_saldo = mysqli_query($conn, "SELECT * FROM transaksi_saldo WHERE id_pengguna = '$id_pengguna' ORDER BY tanggal DESC");

// Ambil riwayat pesanan
$riwayat_pesanan = mysqli_query($conn, "SELECT p.*, pr.nama_produk FROM pesanan p 
                    JOIN produk pr ON p.id_produk = pr.id 
                    WHERE p.id_pengguna = '$id_pengguna' ORDER BY p.tanggal DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Saldo & Riwayat - CUFFLI STORE</title>
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
        .container{max-width:900px; margin:20px auto; padding:15px;}
        .card{background:white; padding:22px; border-radius:8px; box-shadow:0 2px 5px #ddd; margin-bottom:20px;}
        .saldo-besar{font-size:28px; font-weight:bold; color:#28a745; text-align:center; margin:15px 0;}
        .info-user{background:#e9ecef; padding:15px; border-radius:5px; margin-bottom:20px;}
        table{width:100%; border-collapse:collapse; margin-top:15px; font-size:14px;}
        th, td{border:1px solid #eee; padding:12px; text-align:left;}
        th{background:#f8f9fa; font-weight:bold;}
        .status{padding:5px 10px; border-radius:20px; font-size:12px; font-weight:bold; color:white;}
        .menunggu{background:#ffc107; color:#212529;}
        .berhasil{background:#28a745;}
        .gagal{background:#dc3545;}
        .diproses{background:#17a2b8;}
        .selesai{background:#28a745;}
    </style>
</head>
<body>
    <header>
        <h1>💰 Saldo & Riwayat</h1>
    </header>
    <nav>
        <a href="index.php">Beranda</a>
        <a href="produk.php">Produk</a>
        <a href="membership.php">Membership</a>
        <a href="isi-saldo.php" class="btn-red">Isi Saldo</a>
        <a href="https://wa.me/<?= WA_ADMIN1 ?>" target="_blank" class="wa-btn">WA Admin</a>
        <a href="logout.php">Keluar</a>
    </nav>

    <div class="container">
        <div class="card">
            <div class="info-user">
                <h3><?= $user['nama'] ?></h3>
                <p>Email: <?= $user['email'] ?></p>
                <p>Status: <b><?= ucfirst($user['level']) ?></b></p>
            </div>
            
            <h2 style="text-align:center; color:#2c3e50;">Saldo Tersedia</h2>
            <div class="saldo-besar">Rp <?= number_format($user['saldo']) ?></div>
            
            <div style="text-align:center; margin-top:15px;">
                <a href="isi-saldo.php" style="padding:10px 20px; background:#25d366; color:white; text-decoration:none; border-radius:5px; font-weight:bold;">Isi Saldo Sekarang</a>
            </div>
        </div>

        <div class="card">
            <h3>📜 Riwayat Isi Saldo</h3>
            <?php if (mysqli_num_rows($riwayat_saldo) > 0): ?>
            <table>
                <tr>
                    <th>Tanggal</th>
                    <th>Jumlah</th>
                    <th>Total Bayar</th>
                    <th>Status</th>
                </tr>
                <?php while ($r = mysqli_fetch_assoc($riwayat_saldo)): ?>
                <tr>
                    <td><?= date('d/m/Y H:i', strtotime($r['tanggal'])) ?></td>
                    <td>Rp <?= number_format($r['jumlah']) ?></td>
                    <td>Rp <?= number_format($r['total_bayar']) ?></td>
                    <td><span class="status <?= $r['status'] ?>"><?= ucfirst($r['status']) ?></span></td>
                </tr>
                <?php endwhile; ?>
            </table>
            <?php else: ?>
            <p style="text-align:center; color:#666; padding:20px;">Belum ada riwayat isi saldo</p>
            <?php endif; ?>
        </div>

        <div class="card">
            <h3>🛍️ Riwayat Pesanan</h3>
            <?php if (mysqli_num_rows($riwayat_pesanan) > 0): ?>
            <table>
                <tr>
                    <th>Tanggal</th>
                    <th>Produk</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
                <?php while ($r = mysqli_fetch_assoc($riwayat_pesanan)): ?>
                <tr>
                    <td><?= date('d/m/Y H:i', strtotime($r['tanggal'])) ?></td>
                    <td><?= $r['nama_produk'] ?></td>
                    <td>Rp <?= number_format($r['total_bayar']) ?></td>
                    <td><span class="status <?= $r['status'] ?>"><?= ucfirst($r['status']) ?></span></td>
                </tr>
                <?php endwhile; ?>
            </table>
            <?php else: ?>
            <p style="text-align:center; color:#666; padding:20px;">Belum ada pesanan</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
