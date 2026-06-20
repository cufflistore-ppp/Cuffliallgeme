<?php
include '../config.php';
session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

// Proses tambah/ubah/hapus
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['tambah'])) {
        $nama = $_POST['nama'];
        $kategori = $_POST['kategori'];
        $harga = $_POST['harga'];
        $deskripsi = $_POST['deskripsi'];

        mysqli_query($conn, "INSERT INTO produk (nama_produk, kategori, harga, deskripsi, status)
                            VALUES ('$nama', '$kategori', '$harga', '$deskripsi', 'aktif')");
        $pesan = "Produk berhasil ditambahkan!";
    } elseif (isset($_POST['ubah'])) {
        $id = $_POST['id'];
        $nama = $_POST['nama'];
        $kategori = $_POST['kategori'];
        $harga = $_POST['harga'];
        $deskripsi = $_POST['deskripsi'];

        mysqli_query($conn, "UPDATE produk SET nama_produk='$nama', kategori='$kategori', harga='$harga', deskripsi='$deskripsi' WHERE id='$id'");
        $pesan = "Produk berhasil diubah!";
    }
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM produk WHERE id='$id'");
    $pesan = "Produk berhasil dihapus!";
}

// Ambil semua produk
$produk = mysqli_query($conn, "SELECT * FROM produk ORDER BY nama_produk ASC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kelola Produk - Admin</title>
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
        .card{background:white; padding:25px; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.08); margin-bottom:30px;}
        h2{color:#2c3e50; margin-bottom:20px; padding-bottom:10px; border-bottom:1px solid #eee;}
        input, select, textarea{width:100%; padding:12px; margin:8px 0; border:1px solid #ddd; border-radius:5px; font-size:15px;}
        button{padding:12px 20px; background:#28a745; color:white; border:none; border-radius:5px; cursor:pointer; font-weight:bold;}
        .btn-merah{background:#dc3545;}
        .pesan{padding:12px; background:#d4edda; color:#155724; border-radius:5px; margin-bottom:15px; text-align:center;}
        table{width:100%; border-collapse:collapse; margin-top:15px; font-size:14px;}
        th, td{border:1px solid #eee; padding:12px; text-align:left;}
        th{background:#f8f9fa; font-weight:bold;}
    </style>
</head>
<body>
    <header>
        <h1>📦 KELOLA PRODUK</h1>
    </header>

    <nav>
        <a href="dashboard.php">Beranda</a>
        <a href="atur-produk.php" class="active">Kelola Produk</a>
        <a href="atur-pengumuman.php">Pengumuman</a>
        <a href="atur-biaya.php">Pengaturan</a>
        <a href="laporan.php">Laporan</a>
        <a href="logout.php" style="color:#dc3545; float:right;">Keluar</a>
    </nav>

    <div class="container">
        <?php if(isset($pesan)) echo "<div class='pesan'>$pesan</div>"; ?>

        <div class="card">
            <h2>Tambah Produk Baru</h2>
            <form method="post">
                <label>Nama Produk:</label>
                <input type="text" name="nama" required>

                <label>Kategori:</label>
                <select name="kategori" required>
                    <option value="Top Up Game">Top Up Game</option>
                    <option value="Akun Digital">Akun Digital</option>
                    <option value="Jasa Desain">Jasa Desain</option>
                    <option value="Sosmed">Sosmed</option>
                    <option value="Jasa Joki">Jasa Joki</option>
                </select>

                <label>Harga (Rp):</label>
                <input type="number" name="harga" min="1000" required>

                <label>Deskripsi:</label>
                <textarea name="deskripsi" rows="3" required></textarea>

                <button type="submit" name="tambah">Simpan Produk</button>
            </form>
        </div>

        <div class="card">
            <h2>Daftar Semua Produk</h2>
            <table>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
                <?php $no = 1; while ($p = mysqli_fetch_assoc($produk)): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $p['nama_produk'] ?></td>
                    <td><?= $p['kategori'] ?></td>
                    <td>Rp <?= number_format($p['harga']) ?></td>
                    <td>
                        <a href="?edit=<?= $p['id'] ?>" style="color:#1976d2; text-decoration:none; margin-right:10px;">Ubah</a>
                        <a href="?hapus=<?= $p['id'] ?>" onclick="return confirm('Yakin ingin menghapus?')" style="color:#dc3545; text-decoration:none;">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>
</body>
</html>
