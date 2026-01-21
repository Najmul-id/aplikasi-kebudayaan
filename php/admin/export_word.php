<?php
session_start();
require '../konfig.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Header Word
header("Content-Type: application/vnd.ms-word");
header("Content-Disposition: attachment; filename=Laporan_Budaya_Nusantara.doc");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Ambil data (SESUAI STRUKTUR DB)
$budaya = $koneksi->query("SELECT * FROM budaya ORDER BY nama_budaya ASC");
$festival = $koneksi->query("SELECT * FROM festival ORDER BY nama_festival ASC");
$seniman = $koneksi->query("SELECT * FROM seniman ORDER BY nama_seniman ASC");

// BOM UTF-8
echo "\xEF\xBB\xBF";
?>

<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:w="urn:schemas-microsoft-com:office:word"
    xmlns="http://www.w3.org/TR/REC-html40">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 12pt;
        }

        h1 {
            text-align: center;
            color: #8b0000;
            margin-bottom: 5px;
        }

        h2 {
            color: #8b0000;
            margin-top: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
        }

        th {
            background: #e6e6e6;
            text-align: center;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<body>

    <h1>Laporan Budaya Nusantara</h1>
    <p style="text-align:center;">Dicetak pada: <?php echo date("d-m-Y"); ?></p>

    <!-- ================= DATA BUDAYA ================= -->
    <h2>Data Budaya</h2>
    <table>
        <tr>
            <th>No</th>
            <th>Nama Budaya</th>
            <th>Daerah</th>
            <th>Kategori</th>
            <th>Deskripsi</th>
        </tr>
        <?php
        $no = 1;
        while ($r = $budaya->fetch_assoc()) {
            echo '<tr>
        <td>' . $no++ . '</td>
        <td>' . htmlspecialchars($r['nama_budaya']) . '</td>
        <td>' . htmlspecialchars($r['daerah']) . '</td>
        <td>' . htmlspecialchars($r['kategori']) . '</td>
        <td>' . htmlspecialchars($r['deskripsi']) . '</td>
    </tr>';
        }
        ?>
    </table>

    <div class="page-break"></div>

    <!-- ================= DATA FESTIVAL ================= -->
    <h2>Data Festival</h2>
    <table>
        <tr>
            <th>No</th>
            <th>Nama Festival</th>
            <th>Lokasi</th>
            <th>Tanggal</th>
            <th>Deskripsi</th>
        </tr>
        <?php
        $no = 1;
        while ($r = $festival->fetch_assoc()) {
            echo '<tr>
        <td>' . $no++ . '</td>
        <td>' . htmlspecialchars($r['nama_festival']) . '</td>
        <td>' . htmlspecialchars($r['lokasi']) . '</td>
        <td>' . htmlspecialchars($r['tanggal_mulai']) . ' s/d ' . htmlspecialchars($r['tanggal_selesai']) . '</td>
        <td>' . htmlspecialchars($r['deskripsi']) . '</td>
    </tr>';
        }
        ?>
    </table>

    <div class="page-break"></div>

    <!-- ================= DATA SENIMAN ================= -->
    <h2>Data Seniman</h2>
    <table>
        <tr>
            <th>No</th>
            <th>Nama Seniman</th>
            <th>Daerah</th>
            <th>Spesialisasi</th>
            <th>Deskripsi</th>
        </tr>
        <?php
        $no = 1;
        while ($r = $seniman->fetch_assoc()) {
            echo '<tr>
        <td>' . $no++ . '</td>
        <td>' . htmlspecialchars($r['nama_seniman']) . '</td>
        <td>' . htmlspecialchars($r['daerah']) . '</td>
        <td>' . htmlspecialchars($r['spesialisasi']) . '</td>
        <td>' . htmlspecialchars($r['deskripsi']) . '</td>
    </tr>';
        }
        ?>
    </table>

</body>

</html>

<?php
exit;
?>