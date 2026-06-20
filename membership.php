<?php
include 'config.php';
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Membership - CUFFLI STORE</title>
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
        .grid{display:grid; grid-template-columns:repeat(auto-fit, minmax(280px, 1fr)); gap:25px; margin-top:30px;}
        .paket{background:white; border-radius:10px; padding:30px; text-align:center; box-shadow:0 3px 10px rgba(0,0,0,0.1); border-top:5px solid #1976d2;}
        .paket.vip{border-color:#ffc107; transform:scale(1.03);}
        .paket h3{font-size:22px; margin-bottom:15px; color:#2c3e50;}
        .diskon{font-size:24px; font-weight:bold; color:#dc3545; margin:15px 0;}
        .harga{font-size:28px; font-weight:bold; color:#28a745; margin:20px 0;}
        .fitur{margin:20px 0; text-align:left;}
        .fitur p{padding:8px 0; border-bottom:1px solid #eee;}
        .btn{display:block; padding:12px; background:#1976d2; color:white; text-decoration:none; border-radius:5px; font-weight:bold; margin-top:25px;}
        .paket.vip .btn{background:#ff9800;}
    </style>
</head>
<body>
    <header>
        <h1>💎 Paket Membership</h1>
        <p>Dapatkan diskon lebih besar dan layanan prioritas</p>
    </header>
    <nav>
        <a href="index.php">Beranda</a>
        <a href="produk.php">Produk</a>
        <a href="membership.php" class="active">Membership</a>
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
        <div class="grid">
            <div class="paket">
                <h3>Member Biasa</h3>
                <div class="diskon">Diskon 0%</div>
                <div class="harga">Gratis</div>
                <div class="fitur">
                    <p>✅ Akses semua produk</p>
                    <p>✅ Layanan standar</p>
                    <p>✅ Proses normal</p>
                </div>
                <a href="produk.php" class="btn">Gratis Sekarang</a>
            </div>

            <div class="paket">
                <h3>Member Premium</h3>
                <div class="diskon">Diskon 15%</div>
                <div class="harga">Rp 25.000 / 30 Hari</div>
                <div class="fitur">
                    <p>✅ Semua keuntungan member biasa</p>
                    <p>✅ Diskon 15% semua produk</p>
                    <p>✅ Layanan prioritas</p>
                    <p>✅ Proses lebih cepat</p>
                </div>
                <?php if(isset($_SESSION['id_pengguna'])): ?>
                <a href="https://wa.me/<?= WA_ADMIN1 ?>?text=Halo%20Admin,%20saya%20ingin%20upgrade%20ke%20Member%20Premium" target="_blank" class="btn">Upgrade Sekarang</a>
                <?php else: ?>
                <a href="login.php" class="btn">Login Dulu</a>
                <?php endif; ?>
            </div>

            <div class="paket vip">
                <h3>Member VIP</h3>
                <div class="diskon">Diskon 25%</div>
                <div class="harga">Rp 50.000 / 30 Hari</div>
                <div class="fitur">
                    <p>✅ Semua keuntungan Premium</p>
                    <p>✅ Diskon 25% semua produk</p>
                    <p>✅ Layanan 24 jam</p>
                    <p>✅ Produk eksklusif</p>
                    <p>✅ Proses paling cepat</p>
                </div>
                <?php if(isset($_SESSION['id_pengguna'])): ?>
                <a href="https://wa.me/<?= WA_ADMIN1 ?>?text=Halo%20Admin,%20saya%20ingin%20upgrade%20ke%20Member%20VIP" target="_blank" class="btn">Upgrade Sekarang</a>
                <?php else: ?>
                <a href="login.php" class="btn">Login Dulu</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
