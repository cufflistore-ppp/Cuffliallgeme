<?php
include 'config.php';
session_start();

// Cek sudah login atau belum
if (!isset($_SESSION['id_pengguna'])) {
    header('Location: login.php');
    exit;
}

$id_produk = $_GET['id'] ?? 0;
$ambil_produk = mysqli_query($conn, "SELECT * FROM produk WHERE id = '$id_produk' AND status = 'aktif'");
$produk = mysqli_fetch_assoc($ambil_produk);

if (!$produk) {
    echo "Produk tidak ditemukan!";
    exit;
}

// Hitung harga setelah diskon
$id_pengguna = $_SESSION['id_pengguna'];
$ambil_user = mysqli_query($conn, "SELECT level, saldo FROM pengguna WHERE id = '$id_pengguna'");
$user = mysqli_fetch_assoc($ambil_user);
$level = $user['level'];
$saldo_user = $user['saldo'];

$harga_awal = $produk['harga'];
$potongan = $harga_awal * ($diskon[$level] / 100);
$harga_akhir = $harga_awal - $potongan;

// Proses pesanan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data_pesanan = trim($_POST['data_pesanan']);
    
    if ($saldo_user >= $harga_akhir) {
        // Kurangi saldo
        mysqli_query($conn, "UPDATE pengguna SET saldo = saldo - $harga_akhir WHERE id = '$id_pengguna'");
        // Simpan pesanan
        mysqli_query($conn, "INSERT INTO pesanan (id_pengguna, id_produk, data_pesanan, total_bayar, status)
                              VALUES ('$id_pengguna', '$id_produk', '$data_pesanan', '$harga_akhir', 'diproses')");
        $sukses = "Pesanan berhasil dibuat! Silakan tunggu diproses oleh admin.";
    } else {
        $pesan = "Saldo tidak cukup! Silakan isi saldo terlebih dahulu.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Pesan Produk - CUFFLI STORE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        *{font-family:Arial; margin:0; padding:0; box-sizing:border-box;}
        body{background:#f8f9fa;}
        header{background:#2c3e50; color:white; padding:18px; text-align:center;}
        .container{max-width:500px; margin:20px auto; padding:15px;}
        .card{background:white; padding:25px; border-radius:8px; box-shadow:0 2px 5px #ddd;}
        h2{color:#2c3e50; margin-bottom:15px; text-align:center;}
        .info{background:#e9ecef; padding:15px; border-radius:5px; margin-bottom:20px;}
        .harga{font-size:20px; font-weight:bold; color:#28a745; text-align:center; margin:15px 0;}
        input, textarea{width:100%; padding:12px; margin:8px 0; border:1px solid #ddd; border-radius:5px; font-size:16px;}
        button{width:100%; padding:13px; background:#28a745; color:white; border:none; border-radius:5px; font-weight:bold; font-size:16px; cursor:pointer;}
        .pesan{padding:12px; background:#ffebee; color:#c62828; border-radius:5px; margin-bottom:15px; text-align:center;}
        .sukses{padding:12px; background:#e8f5e9; color:#2e7d32; border-radius:5px; margin-bottom:15px; text-align:center;}
        .link{text-align:center; margin-top:15px;}
        .link a{color:#1976d2; text-decoration:none;}
    </style>
</head>
<body>
    <header>
        <h1>🛍️ Pesan Produk</h1>
    </header>
    <div class="container">
        <div class="card">
            <?php
            if(isset($pesan)) echo "<div class='pesan'>$pesan</div>";
            if(isset($sukses)) echo "<div class='sukses'>$sukses</div>";
            ?>

            <h2><?= $produk['nama_produk'] ?></h2>
            <div class="info">
                <p><?= $produk['deskripsi'] ?></p>
                <hr>
                <p>Status Akun: <b><?= ucfirst($level) ?></b></p>
                <?php if ($diskon[$level] > 0): ?>
                    <p>Harga Normal: <s>Rp <?= number_format($harga_awal) ?></s></p>
                    <p>Diskon: <?= $diskon[$level] ?>%</p>
                <?php endif; ?>
                <p class="harga">Total Bayar: Rp <?= number_format($harga_akhir) ?></p>
                <p>Saldo Anda: Rp <?= number_format($saldo_user) ?></p>
            </div>

            <form method="post">
                <label>Data Pesanan:</label>
                <textarea name="data_pesanan" placeholder="Contoh: ID: 123456 | Server: 789 | Email: ..." required rows="4"></textarea>
                <button type="submit">Konfirmasi Pesanan</button>
            </form>

            <div class="link">
                <a href="produk.php">← Kembali ke Daftar Produk</a>
            </div>
        </div>
    </div>
</body>
</html>
