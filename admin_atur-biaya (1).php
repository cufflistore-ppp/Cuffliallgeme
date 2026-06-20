<?php
include '../config.php';
session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $minimal = $_POST['minimal'];
    $biaya = $_POST['biaya'];

    // Bisa disimpan di file config atau database
    // Contoh simpan sederhana:
    $teks = "<?php
define('MINIMAL_SALDO', $minimal);
define('BIAYA_ADMIN', $biaya);
?>";
    file_put_contents('../pengaturan.php', $teks);
    $pesan = "Pengaturan berhasil disimpan!";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Pengaturan - Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        *{font-family:Arial; margin:0; padding:0; box-sizing:border-box;}
        body{background:#f8f9fa;}
        header{background:#2c3e50; color:white; padding:18px; text-align:center;}
        nav{background:white; padding:12px; box-shadow:0 2px 4px rgba(0,0,0,0.1); margin-bottom:20px;}
        nav a{display:inline-block; padding:10px 15px; margin:0 5px; text-decoration:none; color:#333; border-radius:5px;}
        nav a:hover{background:#e9ecef;}
        nav a.active{background:#1976d2; color:white;}
        .container{max-width:500px; margin:0 auto; padding:15px;}
        .card{background:white; padding:25px; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.08);}
        h2{color:#2c3e50; margin-bottom:20px; text-align:center;}
        input{width:100%; padding:13px; margin:10px 0; border:1px solid #ddd; border-radius:5px; font-size:16px;}
        button{width:100%; padding:14px; background:#17a2b8; color:white; border:none; border-radius:5px; font-weight:bold; font-size:16px; cursor:pointer; margin-top:10px;}
        .pesan{padding:12px; background:#d4edda; color:#155724; border-radius:5px; margin-bottom:15px; text-align:center;}
    </style>
</head>
<body>
    <header>
        <h1>⚙️ PENGATURAN TOKO</h1>
    </header>

    <nav>
        <a href="dashboard.php">Beranda</a>
        <a href="atur-produk.php">Kelola Produk</a>
        <a href="atur-pengumuman.php">Pengumuman</a>
        <a href="atur-biaya.php" class="active">Pengaturan</a>
        <a href="laporan.php">Laporan</a>
        <a href="logout.php" style="color:#dc3545; float:right;">Keluar</a>
    </nav>

    <div class="container">
        <div class="card">
            <?php if(isset($pesan)) echo "<div class='pesan'>$pesan</div>"; ?>
            
            <h2>Atur Biaya & Saldo</h2>
            <form method="post">
                <label>Minimal Isi Saldo (Rp):</label>
                <input type="number" name="minimal" value="<?= MINIMAL_SALDO ?>" min="1000" required>

                <label>Biaya Admin Isi Saldo (Rp):</label>
                <input type="number" name="biaya" value="<?= BIAYA_ADMIN ?>" min="0" required>

                <button type="submit">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</body>
</html>
