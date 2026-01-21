<?php
session_start();
require("../konfig.php");

// Ambil ID dari URL
$id = isset($_GET['id']) ? $_GET['id'] : '';

if (!$id) {
    header("Location: festival.php?pesan=Data tidak valid!");
    exit;
}

// Ambil gambar sebelum dihapus
$query = $koneksi->prepare("SELECT gambar FROM festival WHERE id = ?");
$query->bind_param("i", $id);
$query->execute();
$result = $query->get_result();
$festival = $result->fetch_assoc();

if ($festival) {
    // Hapus file gambar jika ada
    if ($festival['gambar'] && file_exists("../../" . $festival['gambar'])) {
        unlink("../../" . $festival['gambar']);
    }
    
    // Hapus dari database
    $delete = $koneksi->prepare("DELETE FROM festival WHERE id = ?");
    $delete->bind_param("i", $id);
    
    if ($delete->execute()) {
        header("Location: festival.php?pesan=Festival berhasil dihapus!");
    } else {
        header("Location: festival.php?pesan=Error saat menghapus!");
    }
    $delete->close();
} else {
    header("Location: festival.php?pesan=Data tidak ditemukan!");
}
?>
