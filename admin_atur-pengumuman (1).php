<?php
include '../config.php';
session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];

    // Nonaktifkan pengumuman lama
    mysqli_query($conn, "UPDATE pengumuman SET status = 'nonaktif'");
    // Simpan pengumuman baru
    mysqli_query($conn, "INSERT INTO pengumuman (judul, isi, status) VALUES ('$judul', '$isi', 'aktif')");
    $pesan = "Pengumuman berhasil diperbarui!";
}

$pengumuman = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pengumuman WHERE status = 'aktif' LIMIT 1"));
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kelola Pengumuman - Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        *{font-family:Arial; margin:0; padding:0; box-sizing:border-box;}
        body{background:#f8f9fa;}
        header{background:#2c3e50; color:white; padding:18px; text-align:center;}
        nav{background:white; padding:12px; box-shadow:0 2px 4px rgba(0,0,0,0.1); margin-bottom:20px;}
        nav a{display:inline-block; padding:10px 15px; margin:0 5px; text-decoration:none; color:#333; border-radius:5px;}
        nav a:hover{background:#e9ecef;}
        nav a.active{background:#1976d2; color:white;}
        .container{max-width:700px; margin:0 auto; padding:15px;}
        .card{background:white; padding:25px; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.08);}
        h2{color:#2c3e50; margin-bottom:20px; text-align:center;}
        input, textarea{width:100%; padding:13px; margin:10px 0; border:1px solid #ddd; border-radius:5px; font-size:16px;}
        button{width:100%; padding:14px; background:#ffc107; color:#212529; border:none; border-radius:5px; font-weight:bold; font-size:16px; cursor:pointer; margin-top:10px;}
        .pesan{padding:12px; background:#d4edda; color:#155724; border-radius:5px; margin-bottom:15px; text-align:center;}
    </style>
</head>
<body>
    <header>
        <h1>📢 KELOLA PENGUMUMAN</h1>
    </header>

    <nav>
        <a href="dashboard.php">Beranda</a>
        <a href="atur-produk.php">Kelola Produk</a>
        <a href="atur-pengumuman.php" class="active">Pengumuman</a>
        <a href="atur-biaya.php">Pengaturan</a>
        <a href="laporan.php">Laporan</a>
        <a href="logout.php" style="color:#dc3545; float:right;">Keluar</a>
    </nav>

    <div class="container">
        <div class="card">
            <?php if(isset($pesan)) echo "<div class='pesan'>$pesan</div>"; ?>
            
            <h2>Buat Pengumuman Baru</h2>
            <form method="post">
                <label>Judul Pengumuman:</label>
                <input type="text" name="judul" value="<?= $pengumuman['judul'] ?? '' ?>" required>

                <label>Isi Pengumuman:</label>
                <textarea name="isi" rows="5" required><?= $pengumuman['isi'] ?? '' ?></textarea>

                <button type="submit">Perbarui Pengumuman</button>
            </form>
        </div>
    </div>
</body>
</html>
