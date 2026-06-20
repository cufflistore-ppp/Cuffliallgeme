<?php
include '../config.php';
session_start();

// Cek apakah sudah login sebagai admin
if (isset($_SESSION['admin'])) {
    header('Location: dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Ganti username dan password ini dengan yang kamu inginkan
    $admin_user = 'admin';
    $admin_pass = 'admin123';

    if ($username == $admin_user && $password == $admin_pass) {
        $_SESSION['admin'] = true;
        header('Location: dashboard.php');
        exit;
    } else {
        $pesan = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Admin - CUFFLI STORE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        *{font-family:Arial; margin:0; padding:0; box-sizing:border-box;}
        body{background:#f0f2f5; display:flex; justify-content:center; align-items:center; min-height:100vh; padding:20px;}
        .box{background:white; padding:35px; border-radius:8px; box-shadow:0 2px 15px rgba(0,0,0,0.1); width:100%; max-width:400px;}
        h2{text-align:center; color:#2c3e50; margin-bottom:25px;}
        input{width:100%; padding:13px; margin:10px 0; border:1px solid #ddd; border-radius:5px; font-size:16px;}
        button{width:100%; padding:14px; background:#2c3e50; color:white; border:none; border-radius:5px; font-weight:bold; font-size:16px; cursor:pointer; margin-top:10px;}
        .pesan{padding:12px; background:#ffebee; color:#c62828; border-radius:5px; margin-bottom:15px; text-align:center;}
        .link{text-align:center; margin-top:20px;}
        .link a{color:#1976d2; text-decoration:none;}
    </style>
</head>
<body>
    <div class="box">
        <h2>🔐 LOGIN ADMIN</h2>
        <?php if(isset($pesan)) echo "<div class='pesan'>$pesan</div>"; ?>
        <form method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Masuk</button>
        </form>
        <div class="link">
            <a href="../index.php">← Kembali ke Toko</a>
        </div>
    </div>
</body>
</html>
