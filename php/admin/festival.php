<?php
session_start();
require("../konfig.php");

// Ambil semua data festival
$query = $koneksi->query("SELECT * FROM festival ORDER BY id DESC");
$data_festival = $query->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Festival Budaya | Admin</title>
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
      <li><a href="festival.php" class="active">Festival Budaya</a></li>
      <li><a href="seniman.php">Seniman</a></li>
      <li><a href="export_pdf.php">Export PDF</a></li>
      <li><a href="export_word.php">Export Word</a></li>
      <li><a href="../../user.php" class="view-website">View Website</a></li>
      <a href="../logout.php" class="logout-btn">Logout</a>
    </ul>
  </aside>

  <main class="main">
    <header class="topbar">
      <h1>Festival Budaya</h1>
    </header>

    <section class="table-section">
      <?php if (isset($_GET['pesan'])): ?>
        <div class="success-msg"><?php echo htmlspecialchars($_GET['pesan']); ?></div>
      <?php endif; ?>
      
      <a href="festival_add.php" class="btn">+ Tambah Festival</a>
      
      <?php if (count($data_festival) > 0): ?>
        <table>
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Festival</th>
              <th>Lokasi</th>
              <th>Tanggal Mulai</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $no = 1;
            foreach ($data_festival as $festival): 
            ?>
              <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo htmlspecialchars($festival['nama_festival']); ?></td>
                <td><?php echo htmlspecialchars($festival['lokasi']); ?></td>
                <td><?php echo date('d-m-Y', strtotime($festival['tanggal_mulai'])); ?></td>
                <td>
                  <a href="festival_edit.php?id=<?php echo $festival['id']; ?>" class="edit">Edit</a>
                  <a href="festival_delete.php?id=<?php echo $festival['id']; ?>" class="delete" onclick="return confirm('Yakin hapus?')">Hapus</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php else: ?>
        <p>Belum ada data festival. <a href="festival_add.php">Tambah sekarang</a></p>
      <?php endif; ?>
    </section>
  </main>
</body>
</html>
