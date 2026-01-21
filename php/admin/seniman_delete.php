<?php
session_start();
require("../konfig.php");

// Ambil ID dari URL
$id = isset($_GET['id']) ? $_GET['id'] : '';

if (!$id) {
    header("Location: seniman.php?pesan=Data tidak valid!");
    exit;
}

// Ambil gambar sebelum dihapus
$query = $koneksi->prepare("SELECT gambar FROM seniman WHERE id = ?");
$query->bind_param("i", $id);
$query->execute();
$result = $query->get_result();
$seniman = $result->fetch_assoc();

if ($seniman) {
    // Hapus file gambar jika ada
    if ($seniman['gambar'] && file_exists("../../" . $seniman['gambar'])) {
        unlink("../../" . $seniman['gambar']);
    }
    
    // Hapus dari database
    $delete = $koneksi->prepare("DELETE FROM seniman WHERE id = ?");
    $delete->bind_param("i", $id);
    
    if ($delete->execute()) {
        header("Location: seniman.php?pesan=Seniman berhasil dihapus!");
    } else {
        header("Location: seniman.php?pesan=Error saat menghapus!");
    }
    $delete->close();
} else {
    header("Location: seniman.php?pesan=Data tidak ditemukan!");
}
?>
