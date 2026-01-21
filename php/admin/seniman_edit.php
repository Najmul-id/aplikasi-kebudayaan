<?php
session_start();
require("../konfig.php");

// Ambil ID dari URL
$id = isset($_GET['id']) ? $_GET['id'] : '';

if (!$id) {
    header("Location: seniman.php");
    exit;
}

// Ambil data seniman
$query = $koneksi->prepare("SELECT * FROM seniman WHERE id = ?");
$query->bind_param("i", $id);
$query->execute();
$result = $query->get_result();
$seniman = $result->fetch_assoc();

if (!$seniman) {
    header("Location: seniman.php?pesan=Data tidak ditemukan!");
    exit;
}

// Cek jika form di-submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_seniman = trim($_POST['nama_seniman']);
    $spesialisasi = trim($_POST['spesialisasi']);
    $daerah = trim($_POST['daerah']);
    $deskripsi = trim($_POST['deskripsi']);
    $gambar = $seniman['gambar'];
    
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
                if ($seniman['gambar'] && file_exists("../../" . $seniman['gambar'])) {
                    unlink("../../" . $seniman['gambar']);
                }
                $gambar = "img/" . time() . "_" . $file_name;
            }
        }
    }
    
    // Update ke database
    $stmt = $koneksi->prepare("UPDATE seniman SET nama_seniman = ?, spesialisasi = ?, daerah = ?, deskripsi = ?, gambar = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $nama_seniman, $spesialisasi, $daerah, $deskripsi, $gambar, $id);
    
    if ($stmt->execute()) {
        header("Location: seniman.php?pesan=Seniman berhasil diperbarui!");
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
    <title>Edit Seniman | Admin</title>
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
        .preview-image {
            max-width: 200px;
            margin-top: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Edit Seniman</h1>
        
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama_seniman">Nama Seniman *</label>
                <input type="text" id="nama_seniman" name="nama_seniman" value="<?php echo htmlspecialchars($seniman['nama_seniman']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="spesialisasi">Spesialisasi *</label>
                <input type="text" id="spesialisasi" name="spesialisasi" value="<?php echo htmlspecialchars($seniman['spesialisasi']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="daerah">Daerah *</label>
                <input type="text" id="daerah" name="daerah" value="<?php echo htmlspecialchars($seniman['daerah']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="deskripsi">Deskripsi *</label>
                <textarea id="deskripsi" name="deskripsi" required><?php echo htmlspecialchars($seniman['deskripsi']); ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="gambar">Gambar</label>
                <?php if ($seniman['gambar']): ?>
                    <div>
                        <img src="../../<?php echo htmlspecialchars($seniman['gambar']); ?>" alt="Gambar Seniman" class="preview-image">
                        <p><small>Gambar saat ini</small></p>
                    </div>
                <?php endif; ?>
                <input type="file" id="gambar" name="gambar" accept="image/*">
                <small>Biarkan kosong jika tidak ingin mengganti gambar</small>
            </div>
            
            <div class="form-actions">
                <button type="submit">Update</button>
                <a href="seniman.php" class="btn-back">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>
