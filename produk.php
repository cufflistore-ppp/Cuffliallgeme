<?php
include 'config.php';
session_start();

// Ambil data pengguna untuk diskon
$id_pengguna = $_SESSION['id_pengguna'] ?? 0;
$level = 'biasa';
if ($id_pengguna) {
    $ambil = mysqli_query($conn, "SELECT level FROM pengguna WHERE id = '$id_pengguna'");
    $data = mysqli_fetch_assoc($ambil);
    $level = $data['level'];
}

// Filter berdasarkan kategori
$kategori = $_GET['kategori'] ?? 'semua';
if ($kategori == 'semua') {
    $where = "WHERE status = 'aktif'";
} else {
    $where = "WHERE kategori = '$kategori' AND status = 'aktif'";
}

$produk = mysqli_query($conn, "SELECT * FROM produk $where ORDER BY nama_produk ASC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Daftar Produk - CUFFLI STORE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        *{font-family:Arial; margin:0; padding:0; box-sizing:border-box;}
        body{background:#f8f9fa;}
        header{background:#2c3e50; color:white; padding:18px; text-align:center;}
        nav{background:#fff; padding:12px; box-shadow:0 2px 4px #ddd; text-align:center; position:sticky; top:0; z-index:99;}
        nav a{margin:0 12px; text-decoration:none; color:#333; font-weight:bold; padding:8px 12px; border-radius:5px;}
        nav a:hover{background:#f0f0f0;}
        nav a.active{background:#1976d2; color:white;}
        .wa-btn{background:#25d366; color:white !important;}
        .btn-red{background:#d32f2f; color:white !important;}
        .container{max-width:1000px; margin:20px auto; padding:15px;}
        .filter{text-align:center; margin-bottom:20px;}
        .filter a{display:inline-block; margin:5px; padding:8px 15px; background:#e9ecef; border-radius:20px; text-decoration:none; color:#333; font-size:14px;}
        .filter a.active{background:#1976d2; color:white;}
        .grid{display:grid; grid-template-columns:repeat(auto-fill, minmax(250px, 1fr)); gap:15px;}
        .card{background:white; border-radius:8px; padding:18px; box-shadow:0 2px 4px #ddd;}
        .nama{font-size:16px; font-weight:bold; margin-bottom:8px; color:#2c3e50;}
        .deskripsi{font-size:14px; color:#666; margin-bottom:12px;}
        .harga-normal{text-decoration:line-through; color:#999; font-size:13px;}
        .diskon{color:#dc3545; font-size:13px; margin:4px 0;}
        .harga{font-size:18px; font-weight:bold; color:#28a745; margin:8px 0;}
        .btn{display:block; text-align:center; padding:10px; background:#1976d2; color:white; text-decoration:none; border-radius:5px; margin-top:12px; font-weight:bold;}
    </style>
</head>
<body>
    <header>
        <h1>🛒 Daftar Produk</h1>
    </header>
    <nav>
        <a href="index.php">Beranda</a>
        <a href="produk.php" class="active">Produk</a>
        <a href="membership.php">Membership</a>
        <a href="isi-saldo.php" class="btn-red">Isi Saldo</a>
        <a href="https://wa.me/<?= WA_ADMIN1 ?>" target="_blank" class="wa-btn">WA Admin</a>
        <?php if(isset($_SESSION['id_pengguna'])): ?>
            <a href="saldo.php">Saldo: Rp <?= number_format($_SESSION['saldo'] ?? 0) ?></a>
            <a href="logout.php">Keluar</a>
        <?php else: ?>
            <a href="login.php">Masuk</a>
        <?php endif; ?>
    </nav>

    <div class="container">
        <div class="filter">
            <a href="produk.php?kategori=semua" class="<?= $kategori == 'semua' ? 'active' : '' ?>">Semua</a>
            <a href="produk.php?kategori=Top Up Game" class="<?= $kategori == 'Top Up Game' ? 'active' : '' ?>">Top Up Game</a>
            <a href="produk.php?kategori=Akun Digital" class="<?= $kategori == 'Akun Digital' ? 'active' : '' ?>">Akun Digital</a>
            <a href="produk.php?kategori=Jasa Desain" class="<?= $kategori == 'Jasa Desain' ? 'active' : '' ?>">Jasa Desain</a>
            <a href="produk.php?kategori=Sosmed" class="<?= $kategori == 'Sosmed' ? 'active' : '' ?>">Sosmed</a>
            <a href="produk.php?kategori=Jasa Joki" class="<?= $kategori == 'Jasa Joki' ? 'active' : '' ?>">Jasa Joki</a>
        </div>

        <div class="grid">
            <?php while ($p = mysqli_fetch_assoc($produk)):
                $harga_awal = $p['harga'];
                $potongan = $harga_awal * ($diskon[$level] / 100);
                $harga_akhir = $harga_awal - $potongan;
            ?>
            <div class="card">
                <h3 class="nama"><?= $p['nama_produk'] ?></h3>
                <p class="deskripsi"><?= $p['deskripsi'] ?></p>
                <?php if ($diskon[$level] > 0): ?>
                    <p class="harga-normal">Rp <?= number_format($harga_awal) ?></p>
                    <p class="diskon">Diskon <?= $diskon[$level] ?>% ➔</p>
                <?php endif; ?>
                <p class="harga">Rp <?= number_format($harga_akhir) ?></p>
                <a href="pesan.php?id=<?= $p['id'] ?>" class="btn">Pesan Sekarang</a>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
