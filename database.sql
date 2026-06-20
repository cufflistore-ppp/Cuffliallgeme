CREATE DATABASE IF NOT EXISTS cuffli_store;
USE cuffli_store;

-- Tabel Pengguna
CREATE TABLE pengguna (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    level ENUM('biasa','premium','vip') DEFAULT 'biasa',
    saldo DECIMAL(12,2) DEFAULT 0,
    tanggal_daftar DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Produk
CREATE TABLE produk (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_produk VARCHAR(255) NOT NULL,
    kategori VARCHAR(100) NOT NULL,
    harga DECIMAL(12,2) NOT NULL,
    deskripsi TEXT,
    status ENUM('aktif','nonaktif') DEFAULT 'aktif'
);

-- Tabel Transaksi Saldo
CREATE TABLE transaksi_saldo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_pengguna INT NOT NULL,
    jumlah DECIMAL(12,2) NOT NULL,
    biaya_admin DECIMAL(12,2) NOT NULL,
    total_bayar DECIMAL(12,2) NOT NULL,
    kode_qr VARCHAR(255) NOT NULL,
    status ENUM('menunggu','berhasil','gagal') DEFAULT 'menunggu',
    referensi VARCHAR(100) UNIQUE NOT NULL,
    tanggal DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_pengguna) REFERENCES pengguna(id)
);

-- Tabel Pesanan Produk
CREATE TABLE pesanan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_pengguna INT NOT NULL,
    id_produk INT NOT NULL,
    data_pesanan TEXT NOT NULL,
    total_bayar DECIMAL(12,2) NOT NULL,
    status ENUM('diproses','selesai','dibatalkan') DEFAULT 'diproses',
    tanggal DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_pengguna) REFERENCES pengguna(id),
    FOREIGN KEY (id_produk) REFERENCES produk(id)
);

-- Tabel Pengumuman Admin
CREATE TABLE pengumuman (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    isi TEXT NOT NULL,
    status ENUM('aktif','nonaktif') DEFAULT 'aktif',
    tanggal DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Contoh Data Produk Awal
INSERT INTO produk (nama_produk, kategori, harga, deskripsi) VALUES
('Top Up ML 110 Diamond', 'Top Up Game', 15000, 'Masukkan ID dan Server Mobile Legends Anda'),
('Top Up FF 140 Diamond', 'Top Up Game', 12500, 'Masukkan ID Free Fire Anda'),
('Jasa Desain Logo', 'Jasa Desain', 35000, 'Dapatkan 3 konsep desain + revisi'),
('Suntik Followers IG 1.000', 'Sosmed', 10000, 'Proses 1-3 jam, aman & permanen'),
('Akun Nokos Indonesia', 'Akun Digital', 8000, 'Akun Gmail siap pakai, verifikasi lengkap'),
('Akun Telegram Indonesia', 'Akun Digital', 12000, 'Nomor Indonesia aktif, siap pakai'),
('Canva Pro 1 Bulan', 'Akun Digital', 18000, 'Akses semua fitur premium Canva'),
('Joki ML Epic ke Mythic', 'Jasa Joki', 50000, 'Dikerjakan oleh pemain profesional');

-- Contoh Pengumuman Awal
INSERT INTO pengumuman (judul, isi) VALUES
('Selamat Datang di CUFFLI STORE!', 'Terima kasih telah berbelanja di toko kami. Layanan buka setiap hari pukul 08.00 - 22.00 WIB. Jika ada kendala, silakan hubungi admin melalui nomor WhatsApp yang tertera.');
