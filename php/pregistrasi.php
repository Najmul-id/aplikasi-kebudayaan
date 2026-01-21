<?php
require("konfig.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    /* VALIDASI */
    if (empty($username) || empty($password)) {
        $error = "Username dan password harus diisi!";
    } elseif (strlen($username) < 3) {
        $error = "Username minimal 3 karakter!";
    } elseif (strlen($password) < 6) {
        $error = "Password minimal 6 karakter!";
    } else {

        /* CEK USERNAME */
        $cek = $koneksi->prepare("SELECT id FROM pengguna WHERE username = ?");
        if (!$cek) {
            $error = "Terjadi kesalahan sistem.";
        } else {
            $cek->bind_param("s", $username);
            $cek->execute();
            $cek->store_result();

            if ($cek->num_rows > 0) {
                $error = "Username sudah terdaftar, silakan gunakan username lain.";
            } else {

                /* HASH PASSWORD */
                $password_hash = password_hash($password, PASSWORD_DEFAULT);

                /* INSERT USER */
                $stmt = $koneksi->prepare(
                    "INSERT INTO pengguna (username, pass) VALUES (?, ?)"
                );

                if (!$stmt) {
                    $error = "Terjadi kesalahan sistem.";
                } else {
                    $stmt->bind_param("ss", $username, $password_hash);

                    if ($stmt->execute()) {
                        header("Location: login.php?pesan=Registrasi berhasil, silakan login.");
                        exit;
                    } else {
                        $error = "Registrasi gagal, silakan coba lagi.";
                    }

                    $stmt->close();
                }
            }
            $cek->close();
        }
    }
}
?>
