<?php
session_start();
require("../konfig.php");

// Cek jika form di-submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_seniman = trim($_POST['nama_seniman']);
    $spesialisasi = trim($_POST['spesialisasi']);
    $daerah = trim($_POST['daerah']);
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
    $stmt = $koneksi->prepare("INSERT INTO seniman (nama_seniman, spesialisasi, daerah, deskripsi, gambar) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nama_seniman, $spesialisasi, $daerah, $deskripsi, $gambar);
    
    if ($stmt->execute()) {
        header("Location: seniman.php?pesan=Seniman berhasil ditambahkan!");
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
    <title>Tambah Seniman | Admin</title>
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
            border-color: #FF9800;
            box-shadow: 0 0 5px rgba(255,152,0,0.3);
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
            background-color: #FF9800;
            color: white;
            flex: 1;
        }
        button:hover {
            background-color: #e68900;
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
        <h1>Tambah Seniman Baru</h1>
        
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama_seniman">Nama Seniman *</label>
                <input type="text" id="nama_seniman" name="nama_seniman" required>
            </div>
            
            <div class="form-group">
                <label for="spesialisasi">Spesialisasi *</label>
                <input type="text" id="spesialisasi" name="spesialisasi" placeholder="Contoh: Tari Bali, Batik Tulis, Gamelan" required>
            </div>
            
            <div class="form-group">
                <label for="daerah">Daerah *</label>
                <input type="text" id="daerah" name="daerah" required>
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
                <a href="seniman.php" class="btn-back">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>
