<?php
include '../config.php';
session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

$pesanan = mysqli_query($conn, "SELECT p.*, pr.nama_produk, u.nama AS nama_pembeli 
                                FROM pesanan p
                                JOIN produk pr ON p.id_produk = pr.id
                                JOIN pengguna u ON p.id_pengguna = u.id
                                ORDER BY p.tanggal DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Laporan - Admin</title>
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
        .card{background:white; padding:25px; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.08);}
        h2{color:#2c3e50; margin-bottom:20px;}
        table{width:100%; border-collapse:collapse; margin-top:15px; font-size:14px;}
        th, td{border:1px solid #eee; padding:12px; text-align:left;}
        th{background:#f8f9fa; font-weight:bold;}
        .status{padding:5px 10px; border-radius:20px; font-size:12px; font-weight:bold; color:white;}
        .diproses{background:#17a2b8;}
        .selesai{background:#28a745;}
        .btn{padding:6px 12px; background:#28a745; color:white; border:none; border-radius:3px; cursor:pointer; text-decoration:none; font-size:12px;}
    </style>
</head>
<body>
    <header>
        <h1>📊 LAPORAN PESANAN</h1>
    </header>

    <nav>
        <a href="dashboard.php">Beranda</a>
        <a href="atur-produk.php">Kelola Produk</a>
        <a href="atur-pengumuman.php">Pengumuman</a>
        <a href="atur-biaya.php">Pengaturan</a>
        <a href="laporan.php" class="active">Laporan</a>
        <a href="logout.php" style="color:#dc3545; float:right;">Keluar</a>
    </nav>

    <div class="container">
        <div class="card">
            <h2>Daftar Semua Pesanan</h2>
            <table>
                <tr>
                    <th>Tanggal</th>
                    <th>Pembeli</th>
                    <th>Produk</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
                <?php while ($p = mysqli_fetch_assoc($pesanan)): ?>
                <tr>
                    <td><?= date('d/m/Y H:i', strtotime($p['tanggal'])) ?></td>
                    <td><?= $p['nama_pembeli'] ?></td>
                    <td><?= $p['nama_produk'] ?></td>
                    <td>Rp <?= number_format($p['total_bayar']) ?></td>
                    <td><span class="status <?= $p['status'] ?>"><?= ucfirst($p['status']) ?></span></td>
                    <td>
                        <?php if ($p['status'] == 'diproses'): ?>
                        <a href="?selesai=<?= $p['id'] ?>" class="btn" onclick="return confirm('Tandai sebagai selesai?')">Selesai</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>
</body>
</html>
