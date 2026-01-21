<?php
session_start();
require("../konfig.php");

// Ambil ID dari URL
$id = isset($_GET['id']) ? $_GET['id'] : '';

if (!$id) {
    header("Location: budaya.php?pesan=Data tidak valid!");
    exit;
}

// Ambil gambar sebelum dihapus
$query = $koneksi->prepare("SELECT gambar FROM budaya WHERE id = ?");
$query->bind_param("i", $id);
$query->execute();
$result = $query->get_result();
$budaya = $result->fetch_assoc();

if ($budaya) {
    // Hapus file gambar jika ada
    if ($budaya['gambar'] && file_exists("../../" . $budaya['gambar'])) {
        unlink("../../" . $budaya['gambar']);
    }
    
    // Hapus dari database
    $delete = $koneksi->prepare("DELETE FROM budaya WHERE id = ?");
    $delete->bind_param("i", $id);
    
    if ($delete->execute()) {
        header("Location: budaya.php?pesan=Budaya berhasil dihapus!");
    } else {
        header("Location: budaya.php?pesan=Error saat menghapus!");
    }
    $delete->close();
} else {
    header("Location: budaya.php?pesan=Data tidak ditemukan!");
}
?>
