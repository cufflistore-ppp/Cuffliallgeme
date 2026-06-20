<?php 
include 'config.php'; 
session_start();

// Ambil pengumuman aktif terbaru
$pengumuman = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pengumuman WHERE status='aktif' ORDER BY tanggal DESC LIMIT 1"));
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= NAMA_TOKO ?></title>
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
        .container{max-width:1000px; margin:20px auto; padding:15px;}
        .card{background:white; border-radius:8px; padding:22px; margin-bottom:20px; box-shadow:0 2px 5px #ddd;}
        .pengumuman{background:#fff3cd; border-left:5px solid #ffc107; padding:18px; border-radius:5px; margin-bottom:20px;}
        .kontak-admin{background:#e8f5e9; border-left:5px solid #2e7d32; padding:18px; border-radius:5px; margin-bottom:20px;}
        .btn{display:inline-block; padding:11px 22px; background:#1976d2; color:white; text-decoration:none; border-radius:5px; margin:6px 4px; font-weight:bold;}
        .btn-green{background:#25d366;}
    </style>
</head>
<body>
    <header>
        <h1>✨ CUFFLI STORE ✨</h1>
        <p>Top Up Game | Akun Digital | Jasa Terpercaya & Cepat</p>
    </header>

    <nav>
        <a href="index.php">Beranda</a>
        <a href="produk.php">Produk</a>
        <a href="membership.php">Membership</a>
        <a href="isi-saldo.php" class="btn-red">Isi Saldo</a>
        <a href="https://wa.me/<?= WA_ADMIN1 ?>" target="_blank" class="wa-btn">WA Admin 1</a>
        <a href="https://wa.me/<?= WA_ADMIN2 ?>" target="_blank" class="wa-btn">WA Admin 2</a>
        <?php if(isset($_SESSION['id_pengguna'])): ?>
            <a href="saldo.php">Saldo: Rp <?= number_format($_SESSION['saldo'] ?? 0) ?></a>
            <a href="logout.php">Keluar</a>
        <?php else: ?>
            <a href="login.php">Masuk/Daftar</a>
        <?php endif; ?>
    </nav>

    <div class="container">
        <?php if($pengumuman): ?>
        <div class="pengumuman">
            <h3>📢 PENGUMUMAN RESMI</h3>
            <hr style="margin:8px 0;">
            <h4><?= $pengumuman['judul'] ?></h4>
            <p><?= nl2br($pengumuman['isi']) ?></p>
            <small style="color:#856404;">Diposting: <?= date('d F Y H:i', strtotime($pengumuman['tanggal'])) ?></small>
        </div>
        <?php endif; ?>

        <div class="kontak-admin">
            <h3>📞 HUBUNGI ADMIN</h3>
            <p>Jika ada kendala, pertanyaan, atau butuh bantuan, silakan hubungi kami:</p>
            <a href="https://wa.me/<?= WA_ADMIN1 ?>" target="_blank" class="btn btn-green">WA: +<?= WA_ADMIN1 ?></a>
            <a href="https://wa.me/<?= WA_ADMIN2 ?>" target="_blank" class="btn btn-green">WA: +<?= WA_ADMIN2 ?></a>
        </div>

        <div class="card">
            <h2>Selamat Datang di CUFFLI STORE</h2>
            <p>Kami menyediakan berbagai layanan digital lengkap mulai dari top up game, akun premium, jasa desain, suntik sosial media, hingga joki game. Pembayaran mudah lewat QRIS, saldo masuk otomatis mulai Rp1.000.</p>
            <br>
            <a href="produk.php" class="btn">Lihat Semua Produk</a>
            <a href="isi-saldo.php" class="btn-red btn">Isi Saldo Sekarang</a>
        </div>

        <div class="card">
            <h3>Kategori Populer</h3>
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(150px,1fr)); gap:12px; margin-top:15px;">
                <a href="produk.php?kategori=Top Up Game" style="padding:16px; background:#e3f2fd; text-align:center; border-radius:8px; text-decoration:none; color:#0d47a1; font-weight:bold;">Top Up Game</a>
                <a href="produk.php?kategori=Akun Digital" style="padding:16px; background:#f3e5f5; text-align:center; border-radius:8px; text-decoration:none; color:#4a148c; font-weight:bold;">Akun Digital</a>
                <a href="produk.php?kategori=Sosmed" style="padding:16px; background:#fff3e0; text-align:center; border-radius:8px; text-decoration:none; color:#e65100; font-weight:bold;">Suntik Sosmed</a>
                <a href="produk.php?kategori=Jasa Joki" style="padding:16px; background:#e8f5e9; text-align:center; border-radius:8px; text-decoration:none; color:#1b5e20; font-weight:bold;">Joki Game</a>
            </div>
        </div>
    </div>
</body>
</html>
