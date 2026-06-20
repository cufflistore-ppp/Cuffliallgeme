<?php
include 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $cek = mysqli_query($conn, "SELECT * FROM pengguna WHERE email = '$email'");
    $data = mysqli_fetch_assoc($cek);

    if ($data && password_verify($password, $data['password'])) {
        $_SESSION['id_pengguna'] = $data['id'];
        $_SESSION['nama'] = $data['nama'];
        $_SESSION['saldo'] = $data['saldo'];
        $_SESSION['level'] = $data['level'];
        header('Location: index.php');
        exit;
    } else {
        $pesan = "Email atau kata sandi salah!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Masuk - CUFFLI STORE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        *{font-family:Arial; margin:0; padding:0; box-sizing:border-box;}
        body{background:#f8f9fa; display:flex; justify-content:center; align-items:center; min-height:100vh; padding:20px;}
        .box{background:white; padding:30px; border-radius:8px; box-shadow:0 2px 10px #ddd; width:100%; max-width:400px;}
        h2{text-align:center; color:#2c3e50; margin-bottom:20px;}
        input{width:100%; padding:12px; margin:8px 0; border:1px solid #ddd; border-radius:5px; font-size:16px;}
        button{width:100%; padding:13px; background:#2c3e50; color:white; border:none; border-radius:5px; font-weight:bold; font-size:16px; cursor:pointer;}
        .link{text-align:center; margin-top:15px;}
        .link a{color:#1976d2; text-decoration:none;}
        .pesan{padding:12px; background:#ffebee; color:#c62828; border-radius:5px; margin-bottom:15px; text-align:center;}
    </style>
</head>
<body>
    <div class="box">
        <h2>🔐 Masuk ke Akun</h2>
        <?php if(isset($pesan)) echo "<div class='pesan'>$pesan</div>"; ?>
        <form method="post">
            <input type="email" name="email" placeholder="Email atau Nomor HP" required>
            <input type="password" name="password" placeholder="Kata Sandi" required>
            <button type="submit">Masuk</button>
        </form>
        <div class="link">
            Belum punya akun? <a href="daftar.php">Daftar Sekarang</a>
        </div>
        <div class="link">
            <a href="index.php">← Kembali ke Beranda</a>
        </div>
    </div>
</body>
</html>
