<?php
include 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $level = 'biasa';
    $saldo = 0;

    // Cek email sudah terdaftar atau belum
    $cek_email = mysqli_query($conn, "SELECT * FROM pengguna WHERE email = '$email'");
    if (mysqli_num_rows($cek_email) > 0) {
        $pesan = "Email sudah digunakan! Silakan pakai email lain.";
    } else {
        $simpan = mysqli_query($conn, "INSERT INTO pengguna (nama, email, password, level, saldo) 
                                        VALUES ('$nama', '$email', '$password', '$level', '$saldo')");
        if ($simpan) {
            $sukses = "Akun berhasil dibuat! Silakan <a href='login.php'>Masuk di sini</a>.";
        } else {
            $pesan = "Gagal mendaftar! Silakan coba lagi nanti.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Daftar Akun - CUFFLI STORE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        *{font-family:Arial; margin:0; padding:0; box-sizing:border-box;}
        body{background:#f8f9fa; display:flex; justify-content:center; align-items:center; min-height:100vh; padding:20px;}
        .box{background:white; padding:30px; border-radius:8px; box-shadow:0 2px 10px #ddd; width:100%; max-width:400px;}
        h2{text-align:center; color:#2c3e50; margin-bottom:20px;}
        input{width:100%; padding:12px; margin:8px 0; border:1px solid #ddd; border-radius:5px; font-size:16px;}
        button{width:100%; padding:13px; background:#2e7d32; color:white; border:none; border-radius:5px; font-weight:bold; font-size:16px; cursor:pointer;}
        .link{text-align:center; margin-top:15px;}
        .link a{color:#1976d2; text-decoration:none;}
        .pesan{padding:12px; background:#ffebee; color:#c62828; border-radius:5px; margin-bottom:15px; text-align:center;}
        .sukses{padding:12px; background:#e8f5e9; color:#2e7d32; border-radius:5px; margin-bottom:15px; text-align:center;}
    </style>
</head>
<body>
    <div class="box">
        <h2>📝 Daftar Akun Baru</h2>
        <?php
        if(isset($pesan)) echo "<div class='pesan'>$pesan</div>";
        if(isset($sukses)) echo "<div class='sukses'>$sukses</div>";
        ?>
        <form method="post">
            <input type="text" name="nama" placeholder="Nama Lengkap" required>
            <input type="email" name="email" placeholder="Email / Nomor HP" required>
            <input type="password" name="password" placeholder="Buat Kata Sandi (min 6 karakter)" required minlength="6">
            <button type="submit">Daftar Sekarang</button>
        </form>
        <div class="link">
            Sudah punya akun? <a href="login.php">Masuk di sini</a>
        </div>
        <div class="link">
            <a href="index.php">← Kembali ke Beranda</a>
        </div>
    </div>
</body>
</html>
