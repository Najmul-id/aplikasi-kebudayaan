<?php
session_start();
require("../konfig.php");

// Ambil ID dari URL
$id = isset($_GET['id']) ? $_GET['id'] : '';

if (!$id) {
    header("Location: budaya.php");
    exit;
}

// Ambil data budaya
$query = $koneksi->prepare("SELECT * FROM budaya WHERE id = ?");
$query->bind_param("i", $id);
$query->execute();
$result = $query->get_result();
$budaya = $result->fetch_assoc();

if (!$budaya) {
    header("Location: budaya.php?pesan=Data tidak ditemukan!");
    exit;
}

// Cek jika form di-submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_budaya = trim($_POST['nama_budaya']);
    $daerah = trim($_POST['daerah']);
    $kategori = trim($_POST['kategori']);
    $deskripsi = trim($_POST['deskripsi']);
    $gambar = $budaya['gambar']; // Default ke gambar lama
    
    // Handle file upload gambar
    if ($_FILES['gambar']['name']) {
        $target_dir = "../../img/";
        $file_name = basename($_FILES['gambar']['name']);
        $target_file = $target_dir . time() . "_" . $file_name;
        
        // Validasi tipe file
        $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        if (in_array($file_ext, $allowed_types)) {
            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
                // Hapus gambar lama jika ada
                if ($budaya['gambar'] && file_exists("../../" . $budaya['gambar'])) {
                    unlink("../../" . $budaya['gambar']);
                }
                $gambar = "img/" . time() . "_" . $file_name;
            }
        }
    }
    
    // Update ke database
    $stmt = $koneksi->prepare("UPDATE budaya SET nama_budaya = ?, daerah = ?, kategori = ?, deskripsi = ?, gambar = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $nama_budaya, $daerah, $kategori, $deskripsi, $gambar, $id);
    
    if ($stmt->execute()) {
        header("Location: budaya.php?pesan=Budaya berhasil diperbarui!");
        exit;
    } else {
        $error = "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Budaya | Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/admin.css">
    <style>
        .form-container {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        input, textarea, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            font-family: Arial, sans-serif;
        }
        textarea {
            resize: vertical;
            min-height: 100px;
        }
        input:focus, textarea:focus, select:focus {
            outline: none;
            border-color: #8b0000;
            box-shadow: 0 0 5px rgba(184, 71, 6, 0.3);
        }
        .form-actions {
            display: flex;
            gap: 10px;
        }
        button, .btn-back {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
        }
        button {
            background-color: #8b0000;
            color: white;
            flex: 1;
        }
        button:hover {
            background-color: #8b0000;
        }
        .btn-back {
            background-color: #757575;
            color: white;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            flex: 1;
        }
        .btn-back:hover {
            background-color: #616161;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .preview-image {
            max-width: 200px;
            margin-top: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Edit Budaya</h1>
        
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama_budaya">Nama Budaya *</label>
                <input type="text" id="nama_budaya" name="nama_budaya" value="<?php echo htmlspecialchars($budaya['nama_budaya']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="daerah">Daerah *</label>
                <input type="text" id="daerah" name="daerah" value="<?php echo htmlspecialchars($budaya['daerah']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="kategori">Kategori *</label>
                <select id="kategori" name="kategori" required>
                    <option value="Tari" <?php echo ($budaya['kategori'] == 'Tari') ? 'selected' : ''; ?>>Tari</option>
                    <option value="Musik" <?php echo ($budaya['kategori'] == 'Musik') ? 'selected' : ''; ?>>Musik</option>
                    <option value="Kerajinan" <?php echo ($budaya['kategori'] == 'Kerajinan') ? 'selected' : ''; ?>>Kerajinan</option>
                    <option value="Rumah Adat" <?php echo ($budaya['kategori'] == 'Rumah Adat') ? 'selected' : ''; ?>>Rumah Adat</option>
                    <option value="Makanan" <?php echo ($budaya['kategori'] == 'Makanan') ? 'selected' : ''; ?>>Makanan</option>
                    <option value="Lainnya" <?php echo ($budaya['kategori'] == 'Lainnya') ? 'selected' : ''; ?>>Lainnya</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="deskripsi">Deskripsi *</label>
                <textarea id="deskripsi" name="deskripsi" required><?php echo htmlspecialchars($budaya['deskripsi']); ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="gambar">Gambar</label>
                <?php if ($budaya['gambar']): ?>
                    <div>
                        <img src="../../<?php echo htmlspecialchars($budaya['gambar']); ?>" alt="Gambar Budaya" class="preview-image">
                        <p><small>Gambar saat ini</small></p>
                    </div>
                <?php endif; ?>
                <input type="file" id="gambar" name="gambar" accept="image/*">
                <small>Biarkan kosong jika tidak ingin mengganti gambar</small>
            </div>
            
            <div class="form-actions">
                <button type="submit">Update</button>
                <a href="budaya.php" class="btn-back">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>
