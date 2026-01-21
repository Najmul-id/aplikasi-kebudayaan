<?php
session_start();
require("../konfig.php");

// Ambil semua data seniman
$query = $koneksi->query("SELECT * FROM seniman ORDER BY id DESC");
$data_seniman = $query->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Seniman | Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/admin.css">
</head>
<body>
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="admin.php">Dashboard</a></li>
            <li><a href="budaya.php">Budaya Nusantara</a></li>
            <li><a href="festival.php">Festival Budaya</a></li>
            <li><a href="seniman.php" class="active">Seniman</a></li>
            <li><a href="export_pdf.php">Export PDF</a></li>
            <li><a href="export_word.php">Export Word</a></li>
            <li><a href="../../user.php" class="view-website">View Website</a></li>
            <a href="../logout.php" class="logout-btn">Logout</a>
        </ul>
    </aside>

    <main class="main">
        <header class="topbar">
            <h1>Seniman Nusantara</h1>
        </header>

        <section class="table-section">
            <?php if (isset($_GET['pesan'])): ?>
                <div class="success-msg"><?php echo htmlspecialchars($_GET['pesan']); ?></div>
            <?php endif; ?>
            
            <a href="seniman_add.php" class="btn">+ Tambah Seniman</a>
            
            <?php if (count($data_seniman) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Seniman</th>
                            <th>Spesialisasi</th>
                            <th>Daerah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        foreach ($data_seniman as $seniman): 
                        ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo htmlspecialchars($seniman['nama_seniman']); ?></td>
                                <td><?php echo htmlspecialchars($seniman['spesialisasi']); ?></td>
                                <td><?php echo htmlspecialchars($seniman['daerah']); ?></td>
                                <td>
                                    <a href="seniman_edit.php?id=<?php echo $seniman['id']; ?>" class="edit">Edit</a>
                                    <a href="seniman_delete.php?id=<?php echo $seniman['id']; ?>" class="delete" onclick="return confirm('Yakin hapus?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Belum ada data seniman. <a href="seniman_add.php">Tambah sekarang</a></p>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
