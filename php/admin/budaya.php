<?php
session_start();
require("../konfig.php");

// Ambil semua data budaya
$query = $koneksi->query("SELECT * FROM budaya ORDER BY id DESC");
$data_budaya = $query->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Budaya Nusantara | Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../css/admin.css">
</head>
<body>
  <!-- SIDEBAR -->
  <aside class="sidebar">
    <h2>Admin Panel</h2>
    <ul>
      <li><a href="admin.php">Dashboard</a></li>
      <li><a href="budaya.php" class="active">Budaya Nusantara</a></li>
      <li><a href="festival.php">Festival Budaya</a></li>
      <li><a href="seniman.php">Seniman</a></li>
      <li><a href="export_pdf.php">Export PDF</a></li>
      <li><a href="export_word.php">Export Word</a></li>
      <li><a href="../../user.php" class="view-website">View Website</a></li>
      <a href="../logout.php" class="logout-btn">Logout</a>
    </ul>
  </aside>

  <!-- MAIN CONTENT -->
  <main class="main">
    <header class="topbar">
      <h1>Budaya Nusantara</h1>
    </header>

    <section class="table-section">
      <?php if (isset($_GET['pesan'])): ?>
        <div class="success-msg"><?php echo htmlspecialchars($_GET['pesan']); ?></div>
      <?php endif; ?>
      
      <a href="budaya_add.php" class="btn">+ Tambah Budaya</a>
      
      <?php if (count($data_budaya) > 0): ?>
        <table>
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Budaya</th>
              <th>Daerah</th>
              <th>Kategori</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $no = 1;
            foreach ($data_budaya as $budaya): 
            ?>
              <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo htmlspecialchars($budaya['nama_budaya']); ?></td>
                <td><?php echo htmlspecialchars($budaya['daerah']); ?></td>
                <td><?php echo htmlspecialchars($budaya['kategori']); ?></td>
                <td>
                  <a href="budaya_edit.php?id=<?php echo $budaya['id']; ?>" class="edit">Edit</a>
                  <a href="budaya_delete.php?id=<?php echo $budaya['id']; ?>" class="delete" onclick="return confirm('Yakin hapus?')">Hapus</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php else: ?>
        <p>Belum ada data budaya. <a href="budaya_add.php">Tambah sekarang</a></p>
      <?php endif; ?>
    </section>
  </main>
</body>
</html>
