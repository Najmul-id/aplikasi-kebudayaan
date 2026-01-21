<?php
session_start();
require("../konfig.php");

// Ambil ID dari URL
$id = isset($_GET['id']) ? $_GET['id'] : '';

if (!$id) {
    header("Location: festival.php");
    exit;
}

// Ambil data festival
$query = $koneksi->prepare("SELECT * FROM festival WHERE id = ?");
$query->bind_param("i", $id);
$query->execute();
$result = $query->get_result();
$festival = $result->fetch_assoc();

if (!$festival) {
    header("Location: festival.php?pesan=Data tidak ditemukan!");
    exit;
}

// Cek jika form di-submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_festival = trim($_POST['nama_festival']);
    $lokasi = trim($_POST['lokasi']);
    $tanggal_mulai = trim($_POST['tanggal_mulai']);
    $tanggal_selesai = trim($_POST['tanggal_selesai']);
    $deskripsi = trim($_POST['deskripsi']);
    $gambar = $festival['gambar'];
    
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
                if ($festival['gambar'] && file_exists("../../" . $festival['gambar'])) {
                    unlink("../../" . $festival['gambar']);
                }
                $gambar = "img/" . time() . "_" . $file_name;
            }
        }
    }
    
    // Update ke database
    $stmt = $koneksi->prepare("UPDATE festival SET nama_festival = ?, lokasi = ?, tanggal_mulai = ?, tanggal_selesai = ?, deskripsi = ?, gambar = ? WHERE id = ?");
    $stmt->bind_param("ssssssi", $nama_festival, $lokasi, $tanggal_mulai, $tanggal_selesai, $deskripsi, $gambar, $id);
    
    if ($stmt->execute()) {
        header("Location: festival.php?pesan=Festival berhasil diperbarui!");
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
    <title>Edit Festival | Admin</title>
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
            border-color: #2196F3;
            box-shadow: 0 0 5px rgba(33,150,243,0.3);
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
            background-color: #2196F3;
            color: white;
            flex: 1;
        }
        button:hover {
            background-color: #0b7dda;
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
        <h1>Edit Festival</h1>
        
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama_festival">Nama Festival *</label>
                <input type="text" id="nama_festival" name="nama_festival" value="<?php echo htmlspecialchars($festival['nama_festival']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="lokasi">Lokasi *</label>
                <input type="text" id="lokasi" name="lokasi" value="<?php echo htmlspecialchars($festival['lokasi']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="tanggal_mulai">Tanggal Mulai *</label>
                <input type="date" id="tanggal_mulai" name="tanggal_mulai" value="<?php echo $festival['tanggal_mulai']; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="tanggal_selesai">Tanggal Selesai</label>
                <input type="date" id="tanggal_selesai" name="tanggal_selesai" value="<?php echo $festival['tanggal_selesai']; ?>">
            </div>
            
            <div class="form-group">
                <label for="deskripsi">Deskripsi *</label>
                <textarea id="deskripsi" name="deskripsi" required><?php echo htmlspecialchars($festival['deskripsi']); ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="gambar">Gambar</label>
                <?php if ($festival['gambar']): ?>
                    <div>
                        <img src="../../<?php echo htmlspecialchars($festival['gambar']); ?>" alt="Gambar Festival" class="preview-image">
                        <p><small>Gambar saat ini</small></p>
                    </div>
                <?php endif; ?>
                <input type="file" id="gambar" name="gambar" accept="image/*">
                <small>Biarkan kosong jika tidak ingin mengganti gambar</small>
            </div>
            
            <div class="form-actions">
                <button type="submit">Update</button>
                <a href="festival.php" class="btn-back">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>
