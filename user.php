<?php
session_start();
require("php/konfig.php");

// Redirect jika belum login
if (!isset($_SESSION['username'])) {
    header("Location: php/login.php");
    exit;
}

// Ambil data dari database
$budaya_data = $koneksi->query("SELECT * FROM budaya ORDER BY id DESC")->fetch_all(MYSQLI_ASSOC);
$festival_data = $koneksi->query("SELECT * FROM festival ORDER BY id DESC")->fetch_all(MYSQLI_ASSOC);
$seniman_data = $koneksi->query("SELECT * FROM seniman ORDER BY id DESC")->fetch_all(MYSQLI_ASSOC);
?>
<!doctype html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <title>Nusantara Budaya</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/style.css" />
  <style>
    .navbar-user {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    
    .user-info {
      display: flex;
      align-items: center;
      gap: 15px;
      margin-right: 20px;
    }
    
    .logout-btn {
      background-color: #e74c3c;
      color: white;
      border: none;
      padding: 8px 15px;
      border-radius: 5px;
      cursor: pointer;
      font-size: 14px;
      transition: background-color 0.3s;
    }
    
    .logout-btn:hover {
      background-color: #c0392b;
    }
  </style>
</head>

<body>
  <!-- ================= NAVBAR ================= -->
  <header class="navbar">
    <div class="navbar-user">
      <div class="logo">Budaya<span>Nusantara</span></div>
      <nav>
        <ul>
          <li><a href="#home">Home</a></li>
          <li><a href="#pencarian">Pencarian</a></li>
          <li><a href="#budaya">Budaya</a></li>
          <li><a href="#festival">Festival Budaya</a></li>
          <li><a href="#seniman">Seniman</a></li>
          <li><a href="#tentang">Tentang</a></li>
          <li><a href="#kontak">Kontak</a></li>
        </ul>
      </nav>
      <div class="user-info">
        <span>Selamat datang, <b><?php echo htmlspecialchars($_SESSION['username']); ?></b></span>
        <button class="logout-btn" onclick="logout()">Logout</button>
      </div>
    </div>
  </header>

  <!-- ================= HERO ================= -->
  <section id="home" class="hero reveal">
    <div class="hero-text">
      <h1>Eksplorasi Budaya Indonesia</h1>
      <p>Mengenal ragam budaya Nusantara dari Sabang sampai Merauke</p>
      <a href="#budaya" class="btn">Jelajahi Budaya</a>
    </div>
  </section>

  <!-- ================= SEARCH ================= -->
  <section id="pencarian" class="search-section reveal">
    <h2>Cari Budaya, Festival, atau Seniman</h2>
    <input type="text" id="searchInput" placeholder="Cari budaya, festival, seniman, atau daerah..." />
  </section>

  <!-- ================= BUDAYA ================= -->
  <section id="budaya" class="budaya-section reveal">
    <h2>Ragam Budaya Indonesia</h2>
    <div class="budaya-grid">
      <?php
      if (count($budaya_data) > 0) {
          foreach ($budaya_data as $item) {
              $gambar = $item['gambar'] ?: 'https://via.placeholder.com/400x300';
              $deskripsi = htmlspecialchars($item['deskripsi']);
              $nama = htmlspecialchars($item['nama_budaya']);
              $daerah = htmlspecialchars($item['daerah']);
              echo "
              <div class=\"budaya-card reveal\" onclick=\"showDetail('$nama', '$daerah', '$deskripsi', '$gambar')\">
                <img src=\"$gambar\" alt=\"$nama\" />
                <h3>$nama</h3>
                <p>$daerah</p>
              </div>
              ";
          }
      }
      ?>
    </div>
  </section>

  <!-- ================= FESTIVAL ================= -->
  <section id="festival" class="budaya-section reveal">
    <h2>Festival Budaya Nusantara</h2>
    <div class="budaya-grid">
      <?php
      if (count($festival_data) > 0) {
          foreach ($festival_data as $item) {
              $gambar = $item['gambar'] ?: 'https://via.placeholder.com/400x300';
              $deskripsi = htmlspecialchars($item['deskripsi']);
              $nama = htmlspecialchars($item['nama_festival']);
              $lokasi = htmlspecialchars($item['lokasi']);
              echo "
              <div class=\"budaya-card reveal\" onclick=\"showDetail('$nama', '$lokasi', '$deskripsi', '$gambar')\">
                <img src=\"$gambar\" alt=\"$nama\" />
                <h3>$nama</h3>
                <p>$lokasi</p>
              </div>
              ";
          }
      }
      ?>
    </div>
  </section>

  <!-- ================= SENIMAN ================= -->
  <section id="seniman" class="budaya-section reveal">
    <h2>Seniman Nusantara</h2>
    <div class="budaya-grid">
      <?php
      if (count($seniman_data) > 0) {
          foreach ($seniman_data as $item) {
              $gambar = $item['gambar'] ?: 'https://via.placeholder.com/400x300';
              $deskripsi = htmlspecialchars($item['deskripsi']);
              $nama = htmlspecialchars($item['nama_seniman']);
              $spesialisasi = htmlspecialchars($item['spesialisasi']);
              echo "
              <div class=\"budaya-card reveal\" onclick=\"showDetail('$nama', '$spesialisasi', '$deskripsi', '$gambar')\">
                <img src=\"$gambar\" alt=\"$nama\" />
                <h3>$nama</h3>
                <p>$spesialisasi</p>
              </div>
              ";
          }
      }
      ?>
    </div>
  </section>

  <!-- ================= MODAL DETAIL ================= -->
  <div class="modal" id="detailModal">
    <div class="modal-content">
      <span class="close" onclick="closeDetail()">&times;</span>
      <h2 id="detailTitle"></h2>
      <h4 id="detailRegion"></h4>
      <p id="detailDesc"></p>
    </div>
  </div>

  <!-- ================= ABOUT ================= -->
  <section id="tentang" class="about-section reveal">
    <h2>Tentang Website</h2>
    <p>
      Nusantara Budaya adalah platform edukasi digital untuk mengenalkan,
      mendokumentasikan, dan melestarikan kekayaan budaya Indonesia.
    </p>
  </section>

  <!-- ================= FOOTER ================= -->
  <footer id="kontak" class="footer">
    <p>&copy; 2026 Nusantara Budaya | Edukasi & Pelestarian Budaya</p>
  </footer>

  <!-- ================= SCRIPT ================= -->
  <script src="js/script.js"></script>
  <script>
    function logout() {
      if (confirm('Apakah Anda yakin ingin keluar?')) {
        window.location.href = 'php/logout.php';
      }
    }
  </script>
</body>

</html>
