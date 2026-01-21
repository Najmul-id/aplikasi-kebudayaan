<?php
session_start();
require("../konfig.php");

// Cek jika form di-submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_budaya = trim($_POST['nama_budaya']);
    $daerah = trim($_POST['daerah']);
    $kategori = trim($_POST['kategori']);
    $deskripsi = trim($_POST['deskripsi']);
    
    // Handle file upload gambar
    $gambar = '';
    if ($_FILES['gambar']['name']) {
        $target_dir = "../../img/";
        $file_name = basename($_FILES['gambar']['name']);
        $target_file = $target_dir . time() . "_" . $file_name;
        
        // Validasi tipe file
        $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        if (in_array($file_ext, $allowed_types)) {
            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
                $gambar = "img/" . time() . "_" . $file_name;
            }
        }
    }
    
    // Insert ke database
    $stmt = $koneksi->prepare("INSERT INTO budaya (nama_budaya, daerah, kategori, deskripsi, gambar) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nama_budaya, $daerah, $kategori, $deskripsi, $gambar);
    
    if ($stmt->execute()) {
        header("Location: budaya.php?pesan=Budaya berhasil ditambahkan!");
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
    <title>Tambah Budaya | Admin</title>
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
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Tambah Budaya Baru</h1>
        
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama_budaya">Nama Budaya *</label>
                <input type="text" id="nama_budaya" name="nama_budaya" required>
            </div>
            
            <div class="form-group">
                <label for="daerah">Daerah *</label>
                <input type="text" id="daerah" name="daerah" required>
            </div>
            
            <div class="form-group">
                <label for="kategori">Kategori *</label>
                <select id="kategori" name="kategori" required>
                    <option value="">-- Pilih Kategori --</option>
                    <option value="Tari">Tari</option>
                    <option value="Musik">Musik</option>
                    <option value="Kerajinan">Kerajinan</option>
                    <option value="Rumah Adat">Rumah Adat</option>
                    <option value="Makanan">Makanan</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="deskripsi">Deskripsi *</label>
                <textarea id="deskripsi" name="deskripsi" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="gambar">Gambar</label>
                <input type="file" id="gambar" name="gambar" accept="image/*">
                <small>Format: JPG, JPEG, PNG, GIF. Maksimal 5MB</small>
            </div>
            
            <div class="form-actions">
                <button type="submit">Simpan</button>
                <a href="budaya.php" class="btn-back">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>
