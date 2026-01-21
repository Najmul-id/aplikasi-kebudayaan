<?php
session_start();
require("konfig.php");

$user = $_POST['username'];
$pass = $_POST['password']; // Password asli dari form input

// 1. Cari user di tabel pengguna
$query = $koneksi->query("SELECT * FROM pengguna WHERE username='$user'");
$data  = $query->fetch_assoc();

if ($data) {
    // 2. Gunakan password_verify untuk mengecek password asli vs hash di database
    if (password_verify($pass, $data['pass'])) {
        // Jika cocok
        $_SESSION['username'] = $data['username'];
        header("Location: ../user.php");
    } else {
        // Jika password salah
        header("Location: login.php?pesan=Password Salah!");
    }
} else {
    // Jika username tidak ditemukan
    header("Location: login.php?pesan=Username tidak terdaftar!");
}
?>