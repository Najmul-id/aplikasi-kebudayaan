<?php
ob_start();
session_start();

require_once '../konfig.php';
require_once __DIR__ . '/dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

/* ===============================
   AMBIL DATA
================================ */
$budaya   = $koneksi->query("SELECT * FROM budaya ORDER BY nama_budaya ASC");
$festival = $koneksi->query("SELECT * FROM festival ORDER BY nama_festival ASC");
$seniman  = $koneksi->query("SELECT * FROM seniman ORDER BY nama_seniman ASC");

/* ===============================
   HTML PDF
================================ */
$html = '
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
@page { margin: 25px; }

body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 10px;
}

h1 {
    text-align: center;
    color: #8b0000;
}

h2 {
    color: #8b0000;
    margin-top: 20px;
}

p {
    text-align: center;
    font-size: 9px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

th, td {
    border: 1px solid #000;
    padding: 5px;
    vertical-align: top;
}

th {
    background: #8b0000;
    color: #fff;
    text-align: center;
}

.page-break {
    page-break-before: always;
}
</style>
</head>
<body>

<h1>Laporan Budaya Nusantara</h1>
<p>Dicetak pada: '.date('d-m-Y').'</p>

<h2>Data Budaya</h2>
<table>
<tr>
    <th>No</th>
    <th>Nama Budaya</th>
    <th>Daerah</th>
    <th>Kategori</th>
    <th>Deskripsi</th>
</tr>';

$no = 1;
while ($r = $budaya->fetch_assoc()) {
    $html .= '
    <tr>
        <td>'.$no++.'</td>
        <td>'.htmlspecialchars($r['nama_budaya']).'</td>
        <td>'.htmlspecialchars($r['daerah']).'</td>
        <td>'.htmlspecialchars($r['kategori']).'</td>
        <td>'.htmlspecialchars($r['deskripsi']).'</td>
    </tr>';
}

$html .= '
</table>

<div class="page-break"></div>

<h2>Data Festival</h2>
<table>
<tr>
    <th>No</th>
    <th>Nama Festival</th>
    <th>Lokasi</th>
    <th>Tanggal</th>
    <th>Deskripsi</th>
</tr>';

$no = 1;
while ($r = $festival->fetch_assoc()) {
    $html .= '
    <tr>
        <td>'.$no++.'</td>
        <td>'.htmlspecialchars($r['nama_festival']).'</td>
        <td>'.htmlspecialchars($r['lokasi']).'</td>
        <td>'.htmlspecialchars($r['tanggal_mulai']).' s/d '.htmlspecialchars($r['tanggal_selesai']).'</td>
        <td>'.htmlspecialchars($r['deskripsi']).'</td>
    </tr>';
}

$html .= '
</table>

<div class="page-break"></div>

<h2>Data Seniman</h2>
<table>
<tr>
    <th>No</th>
    <th>Nama Seniman</th>
    <th>Daerah</th>
    <th>Spesialisasi</th>
    <th>Deskripsi</th>
</tr>';

$no = 1;
while ($r = $seniman->fetch_assoc()) {
    $html .= '
    <tr>
        <td>'.$no++.'</td>
        <td>'.htmlspecialchars($r['nama_seniman']).'</td>
        <td>'.htmlspecialchars($r['daerah']).'</td>
        <td>'.htmlspecialchars($r['spesialisasi']).'</td>
        <td>'.htmlspecialchars($r['deskripsi']).'</td>
    </tr>';
}

$html .= '
</table>

</body>
</html>';

/* ===============================
   GENERATE PDF
================================ */
$options = new Options();
$options->set('defaultFont', 'DejaVu Sans');

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

ob_end_clean();
$dompdf->stream("Laporan_Budaya_Nusantara.pdf", ["Attachment" => true]);
exit;
