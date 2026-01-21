<?php
session_start();
require("../konfig.php");

// Hitung total data
$count_budaya = $koneksi->query("SELECT COUNT(*) as total FROM budaya")->fetch_assoc()['total'];
$count_festival = $koneksi->query("SELECT COUNT(*) as total FROM festival")->fetch_assoc()['total'];
$count_seniman = $koneksi->query("SELECT COUNT(*) as total FROM seniman")->fetch_assoc()['total'];

// Ambil data budaya terbaru (5 data)
$recent_budaya = $koneksi->query("SELECT * FROM budaya ORDER BY id DESC LIMIT 5")->fetch_all(MYSQLI_ASSOC);
?>

<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <title>Dashboard Admin | Nusantara Budaya</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../../css/admin.css" />
  </head>
  <body>
    <!-- SIDEBAR -->
    <aside class="sidebar">
      <h2>Admin Panel</h2>
      <ul>
        <li><a href="admin.php" class="active">Dashboard</a></li>
        <li><a href="budaya.php">Budaya Nusantara</a></li>
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
      <h1>Dashboard</h1>
      <span><a href="account.php">Account</a></span>
    </header>

      <!-- INFO BOX -->
      <section class="cards">
        <div class="card">
          <h3>Ragam Budaya</h3>
          <p><?php echo $count_budaya; ?></p>
        </div>
        <div class="card">
          <h3>Ragam Festival</h3>
          <p><?php echo $count_festival; ?></p>
        </div>
        <div class="card">
          <h3>Ragam Seniman</h3>
          <p><?php echo $count_seniman; ?></p>
        </div>
      </section>

      <!-- TABLE -->
      <section class="table-section">
        <h2>Data Budaya Terbaru</h2>
        <a href="budaya_add.php" class="btn">+ Tambah Budaya</a>
        
        <?php if (count($recent_budaya) > 0): ?>
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
              foreach ($recent_budaya as $budaya): 
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

    <script src="../../js/login.js"></script>
    <script>
      function logout() {
        if (confirm('Yakin ingin logout?')) {
          window.location.href = '../logout.php';
        }
      }
    </script>
  </body>
</html>